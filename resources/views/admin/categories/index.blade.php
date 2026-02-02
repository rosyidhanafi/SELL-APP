@extends('layouts.app')

@section('title', 'Manajemen Kategori - Admin')

@section('content')
    <div class="min-h-screen p-6">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-slate-800 uppercase tracking-wider">
                        <i class="fa-solid fa-boxes-stacked mr-2"></i>
                        Manajemen <span
                            class="bg-blue-500 px-2 py-0.5 rounded-md shadow-md text-white relative">Kategori<span
                                class="text-xs bg-orange-400 py-0.5 px-1 rounded-md text-white shadow-md absolute -top-2 -right-4 rotate-12">Admin</span></span>
                    </h1>
                    <p class="text-slate-600 mt-2">Kelola semua kategori sistem penjualan</p>
                </div>
                <a href="{{ route('admin.categories.create') }}"
                    class="bg-green-500 text-2xl uppercase tracking-wider hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus mr-2"></i>
                    Tambah Kategori
                </a>
            </div>

            <!-- Notification -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p class="font-semibold">✓ {{ session('success') }}</p>
                </div>
            @endif

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">No</th>
                            <th class="px-6 py-3 text-left">Nama Kategori</th>
                            <th class="px-6 py-3 text-left">KODE SKU</th>
                            <th class="px-6 py-3 text-left">Slug</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-600">
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full">
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    <span class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full">
                                        {{ $category->sku }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">
                                    <code class="bg-slate-100 px-3 py-1 rounded text-sm">{{ $category->slug }}</code>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-300">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
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
                                <td colspan="10" class="px-6 py-36 text-center text-slate-300">
                                    <p
                                        class="text-2xl font-semibold tracking-wider italic flex items-center justify-center">
                                        <i class="fa-solid fa-table mr-4 text-5xl"></i>
                                        Belum ada kategori
                                    </p>
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="text-blue-500 hover:underline hover:underline-offset-2 hover:text-blue-700 mt-2 inline-block">
                                        + Tambah kategori baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if ($categories->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
