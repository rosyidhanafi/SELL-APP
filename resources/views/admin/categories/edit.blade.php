@extends('layouts.app')

@section('title', 'Tambah Kategori - Admin')

@section('content')
    <div class="min-h-screen p-6 relative">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.categories.index') }}"
                    class="text-blue-500 hover:text-blue-700 flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-4xl font-bold text-slate-800  uppercase">Form Edit | <span
                        class="bg-orange-500 px-2 py-0.5 rounded-md shadow-md text-white relative">Kategori</span></h1>
                <p class="text-slate-400 mt-2">Edit kategori produk yang sudah ada</p>
                <hr class="my-4">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Kategori -->
                    <div class="flex">
                        <div class="w-5/6">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                placeholder="Contoh: Elektronik, Makanan, Minuman">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-2/6 pl-4">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                KODE SKU <span class="text-red-500">*</span> (3 Huruf)
                            </label>
                            <input type="text" name="sku" value="{{ old('sku', $category->sku) }}" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sku') border-red-500 @enderror"
                                placeholder="Ex: MKN, MIN, SNC">
                            @error('sku')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Slug (URL-friendly)
                        </label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('slug') border-red-500 @enderror"
                            placeholder="Akan otomatis jika kosong (contoh: elektronik)">
                        <p class="text-slate-500 text-sm mt-1">Jika kosong, slug akan otomatis di-generate dari nama</p>
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6 border-t border-slate-200">
                        <button type="submit"
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-pencil"></i>
                            Simpan Kategori
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex-1 bg-slate-500 hover:bg-slate-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-square-caret-left mr-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 absolute absolute left-24 w-60 top-36 text-lg bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-blue-800 font-semibold animate-pulse border-l-4 pl-1 border-orange-400">Informasi Slug</p>
                <p class="text-blue-700 text-sm mt-1">Slug adalah nama kategori dalam format URL-friendly. Contoh:
                    "Elektronik" menjadi "elektronik". Bisa juga diisi manual dengan format kebab-case (contoh:
                    "barang-elektronik").</p>
            </div>
        </div>
    </div>
@endsection
