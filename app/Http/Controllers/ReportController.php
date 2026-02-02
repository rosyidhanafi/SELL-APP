<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = Transaction::with(['user', 'transactionDetails.product'])
            ->where('status', 'paid');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('transactionDetails.product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sort functionality
        $sort = $request->get('sort', 'desc');
        if ($sort === 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $transactions = $query->paginate(10);

        return view('admin.reports.sales', compact('transactions', 'sort'));
    }

    public function salesDetail($id)
    {
        $transaction = Transaction::with(['user', 'transactionDetails.product'])->findOrFail($id);
        return view('admin.reports.sales-detail', compact('transaction'));
    }

    public function salesExport(Request $request)
    {
        $query = Transaction::with(['user', 'transactionDetails.product'])
            ->where('status', 'paid');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('transactionDetails.product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // CSV export
        $filename = 'laporan_penjualan_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No Transaksi', 'Kasir', 'Produk', 'Qty', 'Total', 'Tanggal', 'Metode Bayar']);

            foreach ($transactions as $index => $transaction) {
                foreach ($transaction->transactionDetails as $detail) {
                    fputcsv($file, [
                        str_pad($transaction->id, 6, '0', STR_PAD_LEFT),
                        $transaction->user->name,
                        $detail->product->name,
                        $detail->quantity,
                        'Rp ' . number_format($detail->subtotal, 0, ',', '.'),
                        $transaction->created_at->format('d/m/Y H:i:s'),
                        strtoupper($transaction->payment_method),
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
