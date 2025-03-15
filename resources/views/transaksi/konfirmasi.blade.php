<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Pembayaran Berhasil') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h1 class="card-title text-success">Pembayaran Berhasil!</h1>
                <p class="card-text">Terima kasih telah melakukan pembayaran. Anda dapat melanjutkan ke halaman rental.</p>
                <a href="{{ url('/transaksi') }}" class="btn btn-primary btn-lg mt-3">Menuju ke rental</a>
            </div>
        </div>
    </div>
</x-app-layout>
