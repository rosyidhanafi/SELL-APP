<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction as TransactionModel;
use App\Models\TransactionDetail;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransAPI;

class Transaction extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $categories = Category::all();
        $products = Product::where('is_active', true)->with('category')->get();
        $transactionBill =  TransactionModel::where('status', 'pending')->get();
        return view('cashier.index' , compact('categories', 'products', 'transactionBill'));
    }

    public function selfService()
    {
        $categories = Category::all();
        $products = Product::where('is_active', true)->with('category')->get();
        return view('self-service.index' , compact('categories', 'products'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        try {
            $grandTotal = 0;

            // Hitung total terlebih dahulu
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $grandTotal += $subtotal;
            }

            // Validasi pembayaran
            if ($validated['paid'] < $grandTotal) {
                return back()->with('error', 'Pembayaran gagal! Uang yang diinput kurang. Total: Rp ' . number_format($grandTotal, 0, ',', '.') . ', Dibayar: Rp ' . number_format($validated['paid'], 0, ',', '.'));
            }

            $transaction = TransactionModel::create([
                'user_id' => auth()->id(),
                'transaction_code' => 'TRX-' . date('YmdHis') . '-' . rand(1000, 9999),
                'grand_total' => $grandTotal,
                'paid' => $validated['paid'],
                'payment_method' => $validated['payment_method'],
                'status' => 'paid',
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $subtotal = $product->price * $item['quantity'];

                TransactionDetail::create([
                    'transaction_code' => $transaction->transaction_code,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Update product stock
                $product->decrement('stock', $item['quantity']);
            }

            return redirect()->route('transactions.receipt', $transaction->transaction_code);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    public function checkoutSelfService(Request $request)
    {
        // dd('masuk');
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        try {
            $grandTotal = 0;

            // Hitung total terlebih dahulu
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $grandTotal += $subtotal;
            }

            // Validasi pembayaran
            // if ($validated['paid'] < $grandTotal) {
            //     return back()->with('error', 'Pembayaran gagal! Uang yang diinput kurang. Total: Rp ' . number_format($grandTotal, 0, ',', '.') . ', Dibayar: Rp ' . number_format($validated['paid'], 0, ',', '.'));
            // }

            $transaction = TransactionModel::create([
                'user_id' => 3, // User ID untuk self-service, bisa disesuaikan
                'transaction_code' => 'TRX-' . date('YmdHis') . '-' . rand(1000, 9999),
                'grand_total' => $grandTotal,
                'paid' => 0,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                $subtotal = $product->price * $item['quantity'];

                TransactionDetail::create([
                    'transaction_code' => $transaction->transaction_code,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Update product stock
                // $product->decrement('stock', $item['quantity']);
            }
            if($request->payment_method == 'cash'){
                return redirect()->route('transactions.receiptProposal', $transaction->transaction_code);
            }else{
                return redirect()->route('transactions.checkoutPay', $transaction->transaction_code);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }

    public function checkoutSelfCash(Request $request, $id)
    {
        $transaction = TransactionModel::where('id', $id)->firstOrFail();
        $transaction->update([
            'paid' => $transaction->grand_total,
            'status' => 'paid',
        ]);
        return redirect()->route('transactions.receipt', $transaction->transaction_code);
    }

    public function receipt($transaction_code)
    {
        // Find by transaction_code (not by primary key)
        $transaction = TransactionModel::with('transactionDetails.product')
            ->where('transaction_code', $transaction_code)
            ->firstOrFail();
        return view('cashier.receipt', compact('transaction'));
    }

    public function receiptProposal($transaction_code)
    {
        // Find by transaction_code (not by primary key)
        $transaction = TransactionModel::with('transactionDetails.product')
            ->where('transaction_code', $transaction_code)
            ->firstOrFail();
        return view('self-service.receiptproposal', compact('transaction'));
    }

    public function checkoutPay($transaction_code)
    {
        // dd(config('midtrans.server_key'), config('midtrans.is_production'));
        $transaction = TransactionModel::where('transaction_code', $transaction_code)->firstOrFail();
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_code,
                'gross_amount' => $transaction->grand_total,
            ],
            'customer_details' => [
                'first_name' => 'customer at ' . date('YmdHis'),
                'email' => 'user@selfservice.com',
                'phone' => '000000000',
            ],
            'callbacks' => [
                'finish' => route('transactions.midtransFinish'),
            ],
        ];


        $snapToken = Snap::getSnapToken($params);

        return view('paymentTransaction', compact('snapToken', 'transaction'));
    }

    // Server-side status check that calls Midtrans API and updates DB, then redirects to receipt
    public function result($transaction_code)
    {
        $transaction = TransactionModel::where('transaction_code', $transaction_code)->firstOrFail();

        try {
            $resp = MidtransAPI::status($transaction->transaction_code);
            // support both array and object responses
            if (is_object($resp)) {
                $status = $resp->transaction_status ?? ($resp->status ?? null);
            } else {
                $status = $resp['transaction_status'] ?? ($resp['status'] ?? null);
            }

            // map statuses
            if (in_array($status, ['capture', 'settlement'])) {
                if ($transaction->status !== 'paid') {
                    $transaction->update([
                        'status' => 'paid',
                        'paid' => $transaction->grand_total,
                    ]);

                    $productDetails = TransactionDetail::where('transaction_code', $transaction_code)->get();
                    foreach ($productDetails as $detail) {
                        $product = Product::find($detail->product_id);
                        if ($product) {
                            $product->decrement('stock', $detail->quantity);
                        }
                    }
                }
            } elseif ($status === 'pending') {
                $transaction->update(['status' => 'pending']);
            } elseif (in_array($status, ['cancel', 'expire', 'deny'])) {
                $transaction->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            \Log::error('Midtrans status check failed', ['error' => $e->getMessage()]);
            return redirect()->route('transactions.receipt', $transaction->transaction_code)->with('error', 'Gagal memverifikasi status pembayaran.');
        }

        return redirect()->route('transactions.receipt', $transaction->transaction_code);
    }

    public function midtransCallback(Request $request)
    {
        $transactionCode = $request->order_id;
        $status = $request->transaction_status;

        $transaction = TransactionModel::where(
            'transaction_code',
            $transactionCode
        )->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($status === 'settlement') {
            $transaction->update([
                'status' => 'paid',
                'paid' => $transaction->grand_total,
            ]);

            $productDetails = TransactionDetail::where('transaction_code', $transactionCode)->get();
            foreach ($productDetails as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->decrement('stock', $detail->quantity);
                }
            }
        }

        if (in_array($status, ['cancel', 'expire', 'deny'])) {
            $transaction->update([
                'status' => 'failed'
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    public function finish(Request $request)
    {
        // This method can be used if additional processing is needed after redirection from Midtrans
        // Currently, we handle everything in the result() method
        return redirect()->route('transactions.result', $request->order_id);
    }
}
