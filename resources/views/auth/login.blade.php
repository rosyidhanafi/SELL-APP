@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="flex h-dvh">
        <section class="hero text-left w-2/4 flex justify-center flex-col py-5 pl-32">
            <div class="font-bold text-6xl"><span class="text-9xl">KEDAI</span><br> UNCLE MUTHU</div>
            <p class="text-xl font-semibold ">Dari Warung, <span
                    class="bg-green-400 px-1 p-0 py-0.5 rounded-sm text-white">untuk Rakyat</span>, Soalnya Kami Bukan
                Pemerintah</p>
            <div class="pl-28 mt-12">
                <a class="text-sky-600 text-2xl font-bold text-decoration-none hover:!underline hover:underline-offset-4 transition-all duration-700 delay-300"
                    href="{{ route('self_service.index') }}">Ayok Beli Sekarang ..</a>
            </div>
            <div className="min-h-screen w-full bg-white relative">
        </section>

        <section class="row g-3 w-2/4 py-24 pl-28">
            <div class="w-full h-full bg-white shadow-2xl rounded-md p-10 relative">
                <div class=" mb-8">
                    <h1 class="text-5xl font-bold text-center">SEL-APP</h1>
                    <h1 class="text-center ">No 1 Aplikasi Point Of Sale</h1>
                </div>
                <h1 class="font-light text-2xl text-center">Ayok Login Sekarang !</h1>
                <form action="{{ route('login') }}" method="POST"
                    class="flex flex-col gap-y-4 [&>label]:text-xl [&>input]:mt-4  [&>input]:pb-1 [&>input]:text-2xl py-6 px-8 ">
                    @csrf
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email"
                        class="border-b border-b-slate-400 focus:!border-b focus:border-b-slate-600 outline-none border-none focus:outline-none">
                    <label for="password" class="mt-8">Password</label>
                    <input type="password" name="password" id="password"
                        class="border-b border-b-slate-400 mb-4 focus:!border-b focus:border-b-slate-600 outline-none border-none focus:outline-none">
                    <button type="submit"
                        class="absolute bottom-6 cursor-pointer mx-auto left-12 right-12 bg-sky-400 py-1 uppercase tracking-wider text-2xl font-semibold text-white rounded-md">Login</button>
                </form>
            </div>
        </section>
    </div>
    </div>



@endsection

@section('script')
@endsection
