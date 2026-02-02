@extends('layouts.app')

@section('title', 'Manajemen Produk - Admin')

@section('content')
    <div class="min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-slate-800 uppercase tracking-wider">
                        <i class="fa-solid fa-boxes-stacked mr-2"></i>
                        Manajemen <span class="bg-blue-500 px-2 py-0.5 rounded-md shadow-md text-white relative">Produk<span
                                class="text-xs bg-orange-400 py-0.5 px-1 rounded-md text-white shadow-md absolute -top-2 -right-4 rotate-12">Admin</span></span>
                    </h1>
                    <p class="text-slate-600 mt-2">Kelola semua produk sistem penjualan</p>
                </div>
                <a href="{{ route('admin.products.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white text-xl uppercase tracking-wider font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center gap-2">
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
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">Foto Produk</th>
                            <th class="px-6 py-3 text-left">Nama Produk</th>
                            <th class="px-6 py-3 text-left">Kategori</th>
                            <th class="px-6 py-3 text-left">SKU</th>
                            <th class="px-6 py-3 text-right">Harga</th>
                            <th class="px-6 py-3 text-center">Stock</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
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
                                    @if ($product->is_active)
                                        <span
                                            class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            Tidak Aktif
                                            <i class="fa-solid fa-ban ml-2"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-300">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-300">
                                                <i class="fa-solid fa-circle-minus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-300">
                                    <div class="flex justify-center items-center gap-4 h-48 ">
                                        <i class="fa-solid fa-box-archive text-5xl"></i>
                                        <p class="text-3xl italic">Belum ada produk</p>
                                    </div>
                                    <a href="{{ route('admin.products.create') }}"
                                        class="text-blue-500 hover:text-blue-700 hover:underline-offset-2 hover:underline mt-2 inline-block">
                                        + Tambah produk baru
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
