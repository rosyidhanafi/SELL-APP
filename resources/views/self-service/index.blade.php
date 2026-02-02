@extends('layouts.app')

@section('title', 'Cashier')


@section('content')
    <!-- Toast Notification -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50"></div>

    <div class="container px-4 py-2 relative h-dvh">
        <a href="/" class="absolute top-4 left-14 group flex items-center text-sky-500 hover:text-sky-600  transition-colors">
            <i class="fa-solid fa-angle-left mr-0.5 group-hover:mr-2 transition-all duration-500"></i>
            <span class="">Kembali</span>
        </a>
        <div class="flex gap-4 h-full  p-10">
            <div class="col-md-7 w-4/6">
                <div class="relative">
                    <div
                        class="mb-2  border-b border-slate-300 bg-teal-500/40 backdrop-blur-md flex gap-2 px-4 py-1 rounded-md items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>

                        <h4 class="font-semibold text-2xl  tracking-wider uppercase  text-white ">Daftar
                            Produk</h4>

                    </div>
                    <div class="flex justify-between mb-2 gap-2 outline-sky-500">
                        <div class="w-1/2  flex flex-wrap gap-2 justify-start items-center">
                            <select id="categoryFilter"
                                class="w-2/4 rounded-md text-lg border-none shadow-md  text-slate-500 px-2 py-1 h-10">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    {{-- <button class="px-2 py-1 text-sm rounded-md bg-slate-50 hover:bg-slate-200 shadow-md w-34" id="categoryFilter" value="{{ $cat->name }}">
                                    {{ Str::limit($cat->name, 10, '...') }}</button> --}}
                                @endforeach
                            </select>
                        </div>
                        <div class=" w-2/4 flex gap-2 items-center bg-white  px-2 py-1 rounded-md shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>

                            <input id="searchBox" name="search" type="text"
                                class="group outline-none rounded-md border-none h-8 text-lg text-slate-500 w-full"
                                placeholder="Cari produk berdasarkan nama..." oninput="searchProducts(searchBox.value)">
                        </div>
                    </div>
                    <div id="productGrid"
                        class="grid grid-cols-3 max-h-[90vh] gap-2 overflow-y-auto scrollbar-hide">
                        @foreach ($products as $prod)
                            <div class="product-card col-span-1 row-span-1" data-name="{{ strtolower($prod->name) }}"
                                data-category="{{ $prod->category_id }}">
                                <div class="p-2">
                                    <div
                                        class="group relative bg-white  rounded-md overflow-hidden shadow-md flex flex-col ">
                                        <img src="{{ asset('storage/' . $prod->image_product_path) }}"
                                            alt="{{ $prod->name }}" class="h-40 object-cover">
                                        <p class="text-xs bg-orange-400 py-0.5 p-1 absolute top-2 left-2 text-white">
                                            {{ Str::limit($prod->category->name, 18, '...') }}</p>
                                        <div class="p-3 flex flex-wrap justify-between items-center">
                                            <h6 class="product-name text-left px-2 py-3">
                                                {{ Str::limit($prod->name, 12, '...') }}</h6>
                                            <div class="text-muted bg-green-400 text-white px-2 py-0.5 rounded-md">Rp
                                                {{ number_format($prod->price, 2) }}</div>
                                        </div>
                                        <button
                                            class="group-hover:h-full group-hover:bg-sky-400/90 group-hover:text-white h-4  text-sky-400 absolute bottom-0 left-0 right-0 bg-sky-400 hover:bg-sky-600 transition-all duration-500 mt-2 add-to-cart py-1  text-lg flex justify-center items-center gap-2 uppercase tracking-wide"
                                            data-id="{{ $prod->id }}" data-name="{{ $prod->name }}"
                                            data-price="{{ $prod->price }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>

                                            Tambah</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



            </div>

            <div class="col-md-5 w-2/6 bg-white shadow-md p-10 relative overflow-hidden rounded-md ">
                <div
                    class="flex gap-2 mb-4 items-center bg-orange-400 text-white absolute top-0 right-0 left-0  px-4 py-1.5 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <h4 class="text-2xl tracking-wider  uppercase  ">
                        Keranjang</h4>
                </div>
                <form id="checkoutForm" method="POST" action="{{ route('transactions.selfServiceCheckout') }}">
                    @csrf
                    <input type="hidden" name="paid" id="paid" value="0">
                    <input type="hidden" name="payment_method" id="payment_method" value="cash">
                    <div id="cartItems"
                        class="border-b my-4 border-slate-300 pb-4 max-h-96 h-72 overflow-y-auto scrollbar-hide">
                        <!-- cart items will be rendered here -->


                    </div>
                    <div class="mt-3 text-lg text-slate-600 flex justify-between">
                        <strong>Total</strong>
                        <div class="">
                            Rp.
                            <span id="totalText">0.00</span>
                        </div>
                    </div>
                    <div class="mt-3 text-xm text-slate-600 flex justify-between">
                        <strong class="bg-green-400 px-2  text-white">Discount</strong>
                        <div class=""> -
                            Rp.
                            <span id="totalText">0.00</span>
                        </div>
                    </div>
                    <div class="my-3 flex justify-between items-center gap-4">
                        <hr class="w-5/6"> <span class="text-gray-500">=</span>
                    </div>
                    <div class="mt-3 text-xl text-black flex justify-between">
                        <strong class="bg-sky-500 px-2  text-white">Grand Total</strong>
                        <div class="">
                            Rp.
                            <span id="grandTotalText">0.00</span>
                        </div>
                    </div>
                    <div class="mt-6 px-2 py-3 bg-gray-100 rounded-md">
                        <label for="paid_method" class="tracking-wide font-semibold text-slate-600 px-2">
                            <i class="fa-solid fa-credit-card mr-2"></i>
                            Metode Pembayaran</label>
                        <select name="payment_method" id="paid_method"
                            class="w-full mt-2 rounded-md  border-none outline-none uppercase tracking-widest font-semibold text-center text-slate-500 px-2 py-1 h-10">

                            <option class="h-10" value="cash">Cash</option>
                            <option class="h-10" value="midtrans">Midtrans</option>
                        </select>
                    </div>
                    <div class=" flex justify-between items-center gap-3 mt-3">
                        <button type="button" id="btnCheckout"
                            class="bg-sky-500 w-2/3 uppercase py-3 text-white tracking-wide font-semibold rounded-md shadow-md hover:bg-sky-600 transition-colors flex justify-center items-center">
                            <i class="fa-solid fa-money-bill-1-wave mr-2 text-sm text-white"></i>
                            Bayar
                        </button>
                        <button>
                            <button type="button" onclick="resetCart()"
                                class="bg-red-500 w-1/3 uppercase py-3 text-white tracking-wide font-semibold rounded-md shadow-md hover:bg-red-600 transition-colors flex justify-center items-center">
                                <i class="fa-solid fa-repeat mr-2 text-sm text-white"></i>
                                Reset
                            </button>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // simple client-side search + category filter and improved cart UX
        const cart = {};

        function resetCart() {
            for (let key in cart) delete cart[key];
            renderCart();
            updatePaymentStatus();
        }

        function renderCart() {
            const container = document.getElementById('cartItems');
            container.innerHTML = '';
            let total = 0;
            Object.values(cart).forEach(it => {
                const row = document.createElement('div');
                row.className = 'd-flex justify-content-between align-items-center mb-2';
                row.innerHTML = `
                        <div class=" h-16" id="cart">
                            <div class="flex justify-between items-center mb-2">
                                <div class="" style="flex:1 ">
                                    <div class="text-black text-xl h-8  overflow-y-auto text-ellipsis"> ${it.name}</div>
                                    <div style="width:90px" class="text-sm text-red-400 w-full justify-end">Rp
                                        ${Number(it.price*it.qty).toFixed(2)}</div>

                                </div>
                                <div style="width:120px" class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-secondary" data-action="dec"
                                        data-id="${it.id}">-</button>
                                    <input class="form-control form-control-sm text-center qty-input" data-id="${it.id}"
                                        value="${it.qty}" style="width:60px">
                                    <button class="btn btn-sm btn-outline-secondary" data-action="inc"
                                        data-id="${it.id}">+</button>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2 border-slate-300 mx-3">
            `;
                container.appendChild(row);
                total += it.price * it.qty;
            });
            document.getElementById('totalText').innerText = Number(total).toFixed(2);
            document.getElementById('grandTotalText').innerText = Number(total).toFixed(2);
            document.getElementById('paid').value = total;

            // attach handlers
            document.querySelectorAll('[data-action="inc"]').forEach(btn => btn.onclick = () => {
                const id = btn.dataset.id;
                cart[id].qty++;
                renderCart();
            });
            document.querySelectorAll('[data-action="dec"]').forEach(btn => btn.onclick = () => {
                const id = btn.dataset.id;
                if (cart[id].qty > 1) cart[id].qty--;
                else delete cart[id];
                renderCart();
            });
            document.querySelectorAll('.qty-input').forEach(inp => {
                inp.onchange = () => {
                    const id = inp.dataset.id;
                    const v = parseInt(inp.value) || 1;
                    if (v <= 0) delete cart[id];
                    else cart[id].qty = v;
                    renderCart();
                };
            });
        }

        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                if (!cart[id]) cart[id] = {
                    id: id,
                    name: btn.dataset.name,
                    price: parseFloat(btn.dataset.price),
                    qty: 0
                };
                cart[id].qty++;
                renderCart();
                updatePaymentStatus();
            });
        });

        // Update payment status indicator
        function updatePaymentStatus() {
            const changeShow = document.getElementById('changeInput');
            const ketNominal = document.getElementById('ket-nominal');
            const paidInput = parseFloat(document.getElementById('grandTotalText').innerText.replace(/,/g, '')) || 0;
            const btnCheckout = document.getElementById('btnCheckout');

        }


        // search & filter
        const searchBox = document.getElementById('searchBox');
        const categoryFilter = document.getElementById('categoryFilter');

        function filterProducts() {
            const q = searchBox.value.trim().toLowerCase();
            const cat = categoryFilter.value;
            console.log('Filtering for', q, cat);
            document.querySelectorAll('.product-card').forEach(card => {
                const name = card.dataset.name;
                const c = card.dataset.category;
                const match = (!q || name.includes(q)) && (!cat || cat == c);
                card.style.display = match ? '' : 'none';
            });
        }

        searchBox.addEventListener('input', filterProducts);
        categoryFilter.addEventListener('click', filterProducts);

        // keyboard shortcuts: s => focus search
        document.addEventListener('keydown', (e) => {
            if (e.key === 's' && document.activeElement.tagName.toLowerCase() !== 'input') {
                e.preventDefault();
                searchBox.focus();
            }
            // press 1..9 to add visible product at that index (for quick keys)
            if (/^[1-9]$/.test(e.key) && document.activeElement.tagName.toLowerCase() !== 'input') {
                const idx = parseInt(e.key) - 1;
                const visible = Array.from(document.querySelectorAll('.product-card')).filter(c => c.style
                    .display !== 'none');
                if (visible[idx]) {
                    const btn = visible[idx].querySelector('.add-to-cart');
                    btn.click();
                }
            }
        });

        //format rupiah
        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }

        document.getElementById('btnCheckout').addEventListener('click', () => {
            const paidAmount = parseFloat(document.getElementById('grandTotalText').innerText.replace(/,/g, '')) || 0;

            const items = Object.values(cart).map(i => ({
                product_id: i.id,
                quantity: i.qty
            }));
            if (items.length === 0) {
                showNotification('Keranjang kosong!', 'error');
                return;
            }


            const form = document.getElementById('checkoutForm');
            document.querySelectorAll('input[name^="items"]').forEach(e => e.remove());
            items.forEach((it, idx) => {
                const inpId = document.createElement('input');
                inpId.type = 'hidden';
                inpId.name = `items[${idx}][product_id]`;
                inpId.value = it.product_id;
                form.appendChild(inpId);
                const inpQ = document.createElement('input');
                inpQ.type = 'hidden';
                inpQ.name = `items[${idx}][quantity]`;
                inpQ.value = it.quantity;
                form.appendChild(inpQ);
            });
            console.log('Submitting form with items:', items);
            form.submit();
        });


        // Toast Notification Function
        function showNotification(message, type = 'success', duration = 3000) {
            const container = document.getElementById('notificationContainer');
            const toast = document.createElement('div');

            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ';

            toast.className =
                `${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 mb-3 animate-slideIn`;
            toast.innerHTML = `
                <span class="text-xl font-bold">${icon}</span>
                <span class="text-lg">${message}</span>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('animate-slideOut');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }



        // Check for success message from session
        @if (session('success'))
            showNotification('{{ session('success') }}', 'success', 3000);
        @endif

        @if (session('error'))
            showNotification('{{ session('error') }}', 'error', 3000);
        @endif
    </script>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }

        .animate-slideOut {
            animation: slideOut 0.3s ease-in;
        }
    </style>

@endsection
