<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="bg-primary text-white p-4 rounded">
                                <h3 class="h5">Users</h3>
                                <p class="h2">{{ $user }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-success text-white p-4 rounded">
                                <h3 class="h5">Rentals</h3>
                                <p class="h2">{{ $rental }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-danger text-white p-4 rounded">
                                <h3 class="h5">Transaksi</h3>
                                <p class="h2">{{ $transaksi }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-warning text-white p-4 rounded">
                                <h3 class="h5">Sesi</h3>
                                <p class="h2">{{ $sesi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        
    </script>
</x-app-layout>
