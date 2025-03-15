<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Rincian Transaksi') }}
        </h2>
    </x-slot>
    <div class="container py-12">
        <div class="mb-3">
            <a href="{{ route('riwayat') }}" class="btn btn-primary">Kembali</a>
        </div>

        <div class="card">
            <div class="card-header">
                Detail Transaksi
            </div>
            <div class="card-body">
                <h5 class="card-title">Kode Booking: {{ $transaksi->kode_booking }}</h5>
                <p class="card-text">Nama Penyewa: {{ $transaksi->user->name }}</p>
                <p class="card-text">Rental: {{ $transaksi->rental->nama }}</p>
                <p class="card-text">Sesi: {{ $transaksi->formatted_sesi }}</p>
                <p class="card-text">Tanggal Sewa: {{ $transaksi->formatted_tanggal}}</p>
                <p class="card-text">Total: Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
