@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.reports.sales') }}" class="text-blue-500 hover:text-blue-700 flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Laporan
            </a>
            <h1 class="text-4xl font-bold text-slate-800">📋 Detail Transaksi</h1>
            <p class="text-slate-600 mt-2">Informasi lengkap transaksi #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Transaction Info -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-slate-200">
                <div>
                    <p class="text-slate-600 text-sm">No. Transaksi</p>
                    <p class="text-2xl font-bold text-slate-800">{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-slate-600 text-sm">Kasir</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $transaction->user->name }}</p>
                </div>
                <div>
                    <p class="text-slate-600 text-sm">Tanggal & Waktu</p>
                    <p class="text-lg text-slate-800">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div>
                    <p class="text-slate-600 text-sm">Metode Pembayaran</p>
                    <p class="text-lg font-bold text-orange-600 uppercase">{{ $transaction->payment_method }}</p>
                </div>
                <div>
                    <p class="text-slate-600 text-sm">Status</p>
                    <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-bold">
                        {{ strtoupper($transaction->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="bg-slate-800 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">📦 Detail Barang</h2>
            </div>

            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-300">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nama Produk</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold">Qty</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold">Harga</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->transactionDetails as $detail)
                    <tr class="border-b border-slate-200 hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $detail->product->name }}</td>
                        <td class="px-6 py-4 text-center">{{ $detail->quantity }}</td>
                        <td class="px-6 py-4 text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-green-600">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="space-y-4">
                <div class="flex justify-between border-b border-slate-200 pb-3">
                    <span class="text-slate-600">Total Barang:</span>
                    <span class="font-bold text-slate-800">{{ $transaction->transactionDetails->sum('quantity') }} item</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-3">
                    <span class="text-slate-600">Total Harga:</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-3">
                    <span class="text-slate-600">Dibayar:</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($transaction->paid, 0, ',', '.') }}</span>
                </div>
                @if($transaction->paid > $transaction->grand_total)
                <div class="flex justify-between text-lg pt-3">
                    <span class="font-bold text-slate-800">Kembalian:</span>
                    <span class="font-bold text-blue-600">Rp {{ number_format($transaction->paid - $transaction->grand_total, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
