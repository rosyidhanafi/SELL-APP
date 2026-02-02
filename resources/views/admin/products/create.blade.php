@extends('layouts.app')

@section('title', 'Tambah Produk - Admin')

@section('content')
<div class="min-h-screen p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-slate-800 uppercase">Form Tambah | <span class="bg-blue-500 px-2 py-0.5 text-white rounded-md shadow-md relative">Produk<span
                                class="text-xs bg-orange-400 py-0.5 px-1 rounded-md text-white shadow-md absolute -top-2 -right-4 rotate-12">Admin</span></span></h1>
            <p class="text-slate-600 mt-2">Masukkan data produk yang ingin ditambahkan</p>
            <hr class="my-4">
            <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                {{-- Foto Produk --}}
                <div class="mb-4 ">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Foto Produk
                    </label>
                    <input type="file" name="image_product_path" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama produk">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Kategori
                    </label>
                    <select name="category_id"
                        class="category_id w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        SKU (Stock Keeping Unit)
                    </label>
                    <div class="relative">
                        <span class=" z-30 absolute px-3 py-3.5 h-full left-0 top-0 text-slate-600 font-semibold" id="kode_sku"></span>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                            class="pl-16 w-full rounded-lg px-4 py-3 border border-slate-300  focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sku') border-red-500 @enderror"
                            placeholder="Contoh: 001">
                    </div>
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                        placeholder="Masukkan deskripsi produk (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga dan Stock -->
                <div class="grid grid-cols-2 gap-6">
                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-slate-600 font-semibold">Rp</span>
                            <input type="number" name="price" value="{{ old('price', 0) }}" required step="0.01" min="0"
                                class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror"
                                placeholder="0">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock') border-red-500 @enderror"
                            placeholder="0">
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                        class="w-4 h-4 text-blue-500 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="is_active" class="text-sm font-semibold text-slate-700">
                        Produk Aktif
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-slate-200">
                    <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-circle-plus mr-2"></i>
                        Simpan Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="flex-1 bg-slate-500 hover:bg-slate-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        const categories = @json($categories);
        console.log(categories);

        const categorySelect = document.querySelectorAll('.category_id');

        categorySelect.forEach(select => {
            select.addEventListener('change', function() {
                const selectedCategoryId = this.value;
                const selectedCategory = categories.find(cat => cat.id == selectedCategoryId);

                const skuPrefix = selectedCategory ? selectedCategory.sku : 'sk';
                document.getElementById('kode_sku').textContent = skuPrefix + ' - ';
            });
        });
    </script>
@endsection
