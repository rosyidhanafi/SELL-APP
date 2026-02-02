@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
    <style>
        .toggle-switch {
            position: relative;
            display: inline-flex;
            align-items: center;
            background: #e5e7eb;
            border-radius: 9999px;
            padding: 4px;
            width: 120px;
            height: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: #89d6ae;
        }

        .toggle-slider {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 50%;
            height: 32px;
            background: white;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.active .toggle-slider {
            left: 50%;
            background: #10b981;
        }

        .toggle-label {
            position: relative;
            z-index: 2;
            display: flex;
            width: 100%;
            justify-content: space-around;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .toggle-label span {
            flex: 1;
            text-align: center;
            transition: color 0.3s ease;
            color: #6b7280;
        }

        .toggle-switch.active .toggle-label span:first-child {
            color: white;
        }

        .toggle-switch.active .toggle-label span:last-child {
            color: #6b7280;
        }

        .toggle-switch:not(.active) .toggle-label span:first-child {
            color: #6b7280;
        }

        .toggle-switch:not(.active) .toggle-label span:last-child {
            color: #ef4444;
        }
    </style>
    <div class="min-h-screen  p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-slate-800 uppercase tracking-wider">
                        <i class="fa-solid fa-boxes-stacked mr-2"></i>
                        Manajemen <span class="text-white rounded-md shadow-md bg-blue-500 px-2 py-0.5">Produk</span>
                    </h1>
                    <p class="text-slate-600 mt-2">
                        Kelola daftar produk untuk transaksi penjualan
                    </p>
                </div>
                <a href="{{ route('products.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-2xl uppercase text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus mr-2"></i>
                    Tambah Produk
                </a>
            </div>

            <!-- Notification -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p class="font-semibold">✓ {{ session('success') }}</p>
                </div>
            @endif

            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden pb-4">
                <table class="w-full">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="px-8 py-5 text-center">Foto</th>
                            <th class="px-8 py-5 text-center">Nama Produk</th>
                            <th class="px-8 py-5 text-center">Kategori</th>
                            <th class="px-8 py-5 text-center">SKU</th>
                            <th class="px-8 py-5 text-center">Harga</th>
                            <th class="px-8 py-5 text-center">Stock</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    @if ($product->image_product_path)
                                        <img src="{{ asset('storage/' . $product->image_product_path) }}"
                                            alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span class="text-slate-500 text-sm">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-slate-600">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $product->sku ?? '-' }}</td>
                                <td class="px-6 py-4 text-right font-bold text-slate-800">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST" class="inline toggle-form">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="toggle-switch {{ $product->is_active ? 'active' : '' }}">
                                            <div class="toggle-slider"></div>
                                            <div class="toggle-label">
                                                <span>Aktif</span>
                                                <span>Tidak</span>
                                            </div>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-300">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-300">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                    <p class="text-lg">Belum ada produk</p>
                                    <a href="{{ route('products.create') }}"
                                        class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                                        Tambah produk baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
