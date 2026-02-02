@extends('layouts.app')

@section('title', 'Struk Transaksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Receipt Container -->
        <div class="bg-white rounded-lg shadow-2xl p-8 border-2 border-slate-300" id="receiptContent">
            <!-- Header -->
            <div class="text-center border-b-2 border-dashed border-slate-400 pb-6 mb-6">
                <h1 class="text-4xl font-bold text-slate-800 mb-2">STRUK TRANSAKSI</h1>
                <p class="text-slate-600 text-sm">SEL-APP Point of Sale System</p>
                <p class="text-slate-600 text-sm">{{ now()->format('d/m/Y H:i:s') }}</p>
            </div>

            <!-- Transaction ID & Info -->
            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <div>
                    <p class="text-slate-600">No. Transaksi</p>
                    <p class="text-lg font-bold text-slate-800">{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-slate-600">Kasir</p>
                    <p class="text-lg font-bold text-slate-800">{{ $transaction->user->name }}</p>
                </div>
                <div>
                    <p class="text-slate-600">Metode Pembayaran</p>
                    <p class="text-lg font-bold text-slate-800 uppercase">{{ $transaction->payment_method }}</p>
                </div>
                <div>
                    <p class="text-slate-600">Status</p>
                    <p class="text-lg font-bold text-green-600">{{ strtoupper($transaction->status) }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="border-2 border-dashed border-slate-400 mb-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-400">
                            <th class="text-left p-3 font-bold text-slate-700">BARANG</th>
                            <th class="text-center p-3 font-bold text-slate-700 w-16">QTY</th>
                            <th class="text-right p-3 font-bold text-slate-700">HARGA</th>
                            <th class="text-right p-3 font-bold text-slate-700">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->transactionDetails as $detail)
                        <tr class="border-b border-slate-300">
                            <td class="p-3 text-slate-800">{{ $detail->product->name }}</td>
                            <td class="p-3 text-center font-semibold text-slate-800">{{ $detail->quantity }}</td>
                            <td class="p-3 text-right text-slate-800">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="p-3 text-right font-bold text-slate-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="space-y-3 mb-6 border-b-2 border-dashed border-slate-400 pb-6">
                <div class="flex justify-between text-slate-700">
                    <span>Subtotal:</span>
                    <span class="font-semibold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-slate-800">
                    <span>Total:</span>
                    <span class="text-green-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-700">
                    <span>Dibayar:</span>
                    <span class="font-semibold">Rp {{ number_format($transaction->paid, 0, ',', '.') }}</span>
                </div>
                @if($transaction->paid > $transaction->grand_total)
                <div class="flex justify-between text-lg font-bold text-blue-600">
                    <span>Kembalian:</span>
                    <span>Rp {{ number_format($transaction->paid - $transaction->grand_total, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="text-center text-slate-600 text-sm space-y-2">
                <p class="text-xl font-bold text-slate-800 my-4">✓ TERIMA KASIH ✓</p>
                <p>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                <p class="text-xs text-slate-500">Mohon simpan struk sebagai bukti pembayaran</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 mt-8 justify-center">
            <button onclick="printReceipt()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a60.729 60.729 0 0 1 10.005-4.905m-.02 1.978c.305-1.834 1.275-3.457 2.728-4.658M6.72 13.829d.005-4.905" />
                </svg>
                Cetak Struk
            </button>
            <a href="{{ route('transactions.index') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Transaksi Baru
            </a>
        </div>
    </div>
</div>

<script>
    function printReceipt() {
        const receiptContent = document.getElementById('receiptContent');
        const printWindow = window.open('', '', 'height=600,width=800');

        printWindow.document.write(`
            <html>
            <head>
                <title>STRUK TRANSAKSI</title>
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    body {
                        font-family: 'Courier New', monospace;
                        font-size: 12px;
                        line-height: 1.5;
                    }
                    .receipt {
                        width: 80mm;
                        margin: 20px auto;
                        padding: 10mm;
                        border: 1px solid #000;
                    }
                    .header {
                        text-align: center;
                        border-bottom: 2px dashed #000;
                        padding-bottom: 10px;
                        margin-bottom: 10px;
                    }
                    .header h1 {
                        font-size: 16px;
                        font-weight: bold;
                        margin: 5px 0;
                    }
                    .header p {
                        font-size: 10px;
                    }
                    .info {
                        margin-bottom: 10px;
                        font-size: 11px;
                    }
                    .info-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 5px;
                    }
                    table {
                        width: 100%;
                        margin-bottom: 10px;
                        border-collapse: collapse;
                    }
                    th, td {
                        padding: 5px 0;
                        text-align: left;
                        font-size: 10px;
                        border-bottom: 1px solid #000;
                    }
                    th {
                        border-top: 2px dashed #000;
                        font-weight: bold;
                    }
                    .qty, .price {
                        text-align: right;
                    }
                    .totals {
                        border-top: 2px dashed #000;
                        border-bottom: 2px dashed #000;
                        padding: 10px 0;
                        margin: 10px 0;
                    }
                    .total-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 5px;
                        font-size: 11px;
                    }
                    .total-row.grand {
                        font-weight: bold;
                        font-size: 12px;
                    }
                    .footer {
                        text-align: center;
                        font-size: 10px;
                        margin-top: 10px;
                    }
                    .footer p {
                        margin: 3px 0;
                    }
                </style>
            </head>
            <body>
                <div class="receipt">
                    ${receiptContent.innerHTML}
                </div>
            </body>
            </html>
        `);

        printWindow.document.close();
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 250);
    }

    // Auto print on page load (optional - comment out if not desired)
    // window.addEventListener('load', printReceipt);
</script>

<style>
    @media print {
        body {
            background: white !important;
        }
        .min-h-screen {
            padding: 0 !important;
        }
        .max-w-2xl {
            max-width: 80mm !important;
            margin: 0 !important;
        }
        button, a {
            display: none !important;
        }
    }
</style>

@endsection
