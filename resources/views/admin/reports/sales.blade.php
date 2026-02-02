@extends('layouts.app')

@section('title', 'Laporan Penjualan - Admin')

@section('content')
    <div class="min-h-screen  py-6 ">
        <div class="max-w-[85rem] rounded-tr-2xl mx-auto bg-white p-10">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-slate-800 uppercase tracking-wide ">
                    <i class="fa-solid fa-chart-line mr-2"></i>
                    Laporan <span class="text-red-500">Penjualan</span>
                </h1>
                <p class="text-slate-400 mt-2">Analisis data transaksi penjualan sistem</p>
            </div>
            <!-- Search & Filter Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form action="{{ route('admin.reports.sales') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                🔍 Cari (Produk / Kasir)
                            </label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Ketik nama produk atau kasir...">
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                📅 Urutkan
                            </label>
                            <select name="sort"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Terbaru
                                </option>
                                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama
                                </option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                Cari
                            </button>
                            <a href="{{ route('admin.reports.sales') }}"
                                class="flex-1 bg-slate-400 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded-lg transition duration-300 text-center">
                                Reset
                            </a>
                            <a href="{{ route('admin.reports.sales-export', request()->query()) }}"
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300"
                                title="Export CSV">
                                📥 Export
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total Transaksi -->
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-slate-600 text-sm">Total Transaksi</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $transactions->total() }}</p>
                </div>

                <!-- Total Penjualan -->
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-slate-600 text-sm">Total Penjualan</p>
                    <p class="text-2xl font-bold text-green-600">Rp
                        {{ number_format($transactions->sum('grand_total'), 0, ',', '.') }}</p>
                </div>

                <!-- Rata-rata Transaksi -->
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-slate-600 text-sm">Rata-rata Transaksi</p>
                    <p class="text-2xl font-bold text-purple-600">Rp
                        {{ $transactions->total() > 0 ? number_format($transactions->sum('grand_total') / $transactions->total(), 0, ',', '.') : '0' }}
                    </p>
                </div>

                <!-- Metode Pembayaran -->
                <div class="bg-white rounded-lg shadow p-4">
                    <p class="text-slate-600 text-sm">Metode Pembayaran</p>
                    <p class="text-2xl font-bold text-orange-600">Cash</p>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No Transaksi</th>
                            <th class="px-6 py-3 text-left">Kasir</th>
                            <th class="px-6 py-3 text-left">Produk</th>
                            <th class="px-6 py-3 text-center">Qty</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            @foreach ($transaction->transactionDetails as $detail)
                                <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                            {{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">{{ $transaction->user->name }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $detail->product->name }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $detail->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-green-600">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.reports.sales-detail', $transaction->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition duration-300">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                    <p class="text-lg">Tidak ada data transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if ($transactions->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
