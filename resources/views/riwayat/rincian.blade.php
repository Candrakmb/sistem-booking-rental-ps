<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Rincian Transaksi') }}
        </h2>
    </x-slot>
    <div class="container py-12">
        <div class="mb-3">
            @if($type == 'admin')
                <a href="{{ route('report') }}" class="btn btn-primary">Kembali</a>
            @else
                <a href="{{ route('riwayat') }}" class="btn btn-primary">Kembali</a>
            @endif
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Invoice Penyewaan</h4>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <strong>Kode Booking:</strong> {{ $transaksi->kode_booking }}
                </div>
        
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><strong>Nama Penyewa</strong></td>
                            <td>: {{ $transaksi->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Rental</strong></td>
                            <td>: {{ $transaksi->rental->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Paket</strong></td>
                            <td>: {{ $transaksi->formatted_sesi }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Sewa</strong></td>
                            <td>: {{ $transaksi->formatted_tanggal }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td>: <strong>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Status Transaksi</strong></td>
                            <td>: {{ $transaksi->status_transaksi }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status Pembayaran</strong></td>
                            <td>: {{ $transaksi->status_pembayaran }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</x-app-layout>
