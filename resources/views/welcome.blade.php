@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="flex h-dvh">
        <section class="hero text-left w-2/4 flex justify-center flex-col py-5 h-screen pl-32">
            <div class="font-bold text-6xl"><span class="text-9xl">KEDAI</span><br> UNCLE MUTHU</div>
            <p class="text-xl font-semibold ">Dari Warung, <span
                    class="bg-green-400 px-1 p-0 py-0.5 rounded-sm text-white">untuk Rakyat</span>, Soalnya Kami Bukan
                Pemerintah</p>
            <div class="pl-28 mt-12">
                <a class="text-sky-600 text-2xl font-bold text-decoration-none hover:!underline hover:underline-offset-4 transition-all duration-700 delay-300"
                    href="{{ route('self_service.index') }}">Ayok Beli Sekarang ..</a>
            </div>
        </section>

        <section class="row  w-2/4 h-screen py-24 pl-28 relative ">
            @if (Route::has('login'))
                <div class="absolute z-50 top-18 right-40">
                    <a href="{{ route('login') }}"
                        class=" border-2 hover:bg-slate-100 uppercase hover:-translate-x-1 hover:-translate-y-1 hover:scale-105 hover:border-slate-100 border-slate-400 font-bold py-2 px-6 rounded-lg  transition duration-300 flex items-center gap-2">
                        Login
                    </a>
                </div>
            @endif
            <div class="mt-12 flex flex-col gap-y-2 h-[70vh]">
                <div
                    class="flex h-1/2  justify-start gap-x-2 rounded-md [&>a:hover]:-translate-x-3 [&>a:hover]:-translate-y-3 mr-20">
                    <a href="{{ route('transactions.index') }}"
                        class=" bg-sky-400/20 hover:rounded-xl hover:bg-sky-400/80 w-1/2 flex flex-col justify-center items-center backdrop-blur-2xl  text-2xl font-bold text-decoration-none text-white transition-all duration-700 delay-300">
                        <i class="fa-solid fa-cash-register mb-2 text-6xl"></i>
                        <span class="uppercase">Kasir</span>
                        <p class="text-xs ">Modul Kasir User Friendly</p>
                    </a>
                    <a href="{{ route('self_service.index') }}"
                        class=" bg-sky-400/20 hover:rounded-xl hover:bg-sky-400/80 w-1/2 flex flex-col justify-center items-center backdrop-blur-2xl  text-2xl font-bold text-decoration-none text-white transition-all duration-700 delay-300">
                        <i class="fa-solid fa-hand-middle-finger mb-2 text-6xl"></i>
                        <span class="uppercase">self - service</span>
                        <p class="text-xs ">Feature Self Service Pembelian</p>
                    </a>
                </div>
                <div
                    class="flex h-1/2  justify-start gap-x-2 rounded-md [&>a:hover]:-translate-x-3 [&>a:hover]:-translate-y-3 mr-20">
                    <a href="{{ route('admin.products.index') }}"
                        class=" bg-sky-400/20 hover:rounded-xl hover:bg-sky-400/80 w-1/2 flex flex-col justify-center items-center backdrop-blur-2xl  text-2xl font-bold text-decoration-none text-white transition-all duration-700 delay-300">
                        <i class="fa-solid fa-list-check mb-2 text-6xl"></i>
                        <span class="uppercase">Manajemen</span>
                        <p class="text-xs ">Manajemen Produk dan User</p>
                    </a>
                    <a href="{{ route('admin.reports.sales') }}"
                        class=" bg-sky-400/20 hover:rounded-xl hover:bg-sky-400/80 w-1/2 flex flex-col justify-center items-center backdrop-blur-2xl  text-2xl font-bold text-decoration-none text-white transition-all duration-700 delay-300">
                        <i class="fa-solid fa-chart-area mb-2 text-6xl"></i>
                        <span class="uppercase">Laporan</span>
                        <p class="text-xs ">Rekap Transaksi Penjualan </p>
                    </a>
                </div>
            </div>
            <svg viewBox="-100 -100 240 240" xmlns="http://www.w3.org/2000/svg" class="opacity-50 absolute top-36 -z-30 ">
                <path
                    d="M 63.43402912043689,0 C 59.25110131391739,21.998339812518296 67.2970090123099,19.666685196954276 60.094314193587714,38.620270681911784 C 52.89161937486552,57.57385616686929 52.3290731978259,66.81398722802108 34.62324984554812,75.81434193983003 C 16.917426493270348,84.81469665163898 11.32408953397598,78.11401705127574 -10.728979215523394,74.62168952914759 C -32.78204796502277,71.12936200701944 -37.37124189433909,74.95090527732516 -53.58902515244938,61.845031851317444 C -69.80680841055967,48.739158425309725 -67.69663448969969,43.91391362299666 -75.60011224796456,22.198195825116695 C -83.50359000622943,0.48247802723673416 -94.08376028290242,-7.9055126220093825 -85.20293618550886,-25.0178393402024 C -76.3221120881153,-42.13016605839542 -58.25198105395282,-30.76676202659303 -40.07681585839034,-46.25111104765537 C -21.901650662827862,-61.735460068717714 -32.55814134900322,-76.54078901568343 -12.502275403258952,-86.95523542445176 C 7.5535905424853205,-97.36968183322008 17.814572718855576,-97.30443339680124 40.146647924586745,-87.90889668272865 C 62.47872313031792,-78.51335996865606 71.00418012070318,-71.35031273884357 76.82602541966573,-49.3730885681614 C 82.64787071862827,-27.395864397479237 67.61695692695639,-21.998339812518296 63.43402912043689,0 Z"
                    fill="#E84A5F" />
            </svg>

        </section>
    </div>
    </div>



@endsection

@section('script')
@endsection
