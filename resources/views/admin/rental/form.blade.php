<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Riwayat') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="card">
            <div class="mb-3">
                <a href="{{ route('rental.table') }}" class="btn btn-primary">Kembali</a>   
            </div>
            <div class="card-header">
                Tambah Rental
            </div>
            <div class="card-body">
                <form id="form-data" method="post" action="" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $type == 'update' ?  $rental->id : '' }}">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama </label>
                        <input type="text" class="form-control required" id="nama" name="nama" value="{{ $type == 'update' ?  $rental->nama : '' }}" required>
                        <p class="help-block" style="display: none; color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah </label>
                        <input type="number" class="form-control required" id="jumlah" value="{{ $type == 'update' ?  $rental->jumlah : '' }}" name="jumlah" required>
                        <p class="help-block" style="display: none; color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga </label>
                        <input type="number" value="{{ $type == 'update' ?  $rental->harga : '' }}" class="form-control required" id="harga" name="harga" required>
                        <p class="help-block" style="display: none; color: red;"></p>
                    </div>
                    <div>
                        <button type="button" id="simpan" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('after-script')
        @include('admin.rental.script')
    @endpush
</x-app-layout>
