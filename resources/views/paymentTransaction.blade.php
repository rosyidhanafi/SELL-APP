@extends('layouts.app')

@section('head')
    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>
@endsection

@section('content')
    <div class="container mx-auto h-full bg-white/40 backdrop-blur-2xl p-4 flex flex-col items-center justify-center">
        <h2 class="text-5xl font-bold mb-4 uppercase tracking-wider"><span class="bg-green-400 px-2 py-0.5 text-white rounded   -md shadow-md">Proses</span> Pembayaran</h2>
        <p class="text-slate-300 text-2xl animate-pulse">Silakan tunggu, Anda akan diarahkan ke halaman pembayaran...</p>
    </div>
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        // Optional: Trigger payment popup automatically

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                swal.fire({
                    title: 'Pembayaran Berhasil!',
                    text: 'Transaksi telah berhasil diproses. Memverifikasi status...',
                    icon: 'success',
                }).then(() => {
                    // Redirect to server-side status check which will update DB and redirect to receipt
                    window.location.href = "{{ route('transactions.result', $transaction->transaction_code) }}";
                });
            },
            onPending: function(result) {
                swal.fire({
                    title: 'Pembayaran Tertunda',
                    text: 'Silakan selesaikan pembayaran Anda. Memverifikasi status...',
                    icon: 'info',
                }).then(() => {
                    window.location.href = "{{ route('transactions.result', $transaction->transaction_code) }}";
                });
            },
            onError: function(result) {
                swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: 'Pembayaran gagal. Silakan coba lagi.',
                    icon: 'error',
                });
            }
        });
    </script>
