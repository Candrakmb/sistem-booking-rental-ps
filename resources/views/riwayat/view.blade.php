<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Riwayat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Rental</th>
                                <th>Paket</th>
                                <th>Status</th>
                                <th>pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $riwayat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $riwayat->formatted_tanggal }}</td>
                                <td>{{ $riwayat->rental->nama }}</td>
                                <td>{{ $riwayat->sesi->nama }}</td>
                                <td>{{ $riwayat->status_transaksi }}</td>
                                <td>{{ $riwayat->status_pembayaran }}</td>
                                <td>
                                    @if ( $type == 'admin')
                                        <a href="{{ route('report.detail', $riwayat->id) }}" class="btn btn-primary">Detail</a>
                                    @else
                                        <a href="{{ route('riwayat.detail', $riwayat->id) }}" class="btn btn-primary"> {{auth()->user()->role}} Detail</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
