<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Form Sesi') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="mb-3">
            <a href="{{ route('sesi.table') }}" class="btn btn-primary">Kembali</a>   
        </div>
        <div class="card">
            <div class="card-header">
                Tambah Rental
            </div>
            <div class="card-body">
                <form id="form-data" method="post" action="" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $type == 'update' ?  $sesi->id : '' }}">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama </label>
                        <input type="text" class="form-control required" id="nama" name="nama" value="{{ $type == 'update' ?  $sesi->nama : '' }}" required>
                        <p class="help-block" style="display: none; color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Waktu Mulai </label>
                        <input type="time" class="form-control required" id="start" value="{{ $type == 'update' ?  $sesi->start : '' }}" name="start" required>
                        <p class="help-block" style="display: none; color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">Waktu Akhir </label>
                        <input type="time" value="{{ $type == 'update' ?  $sesi->end : '' }}" class="form-control required" id="end" name="end" required>
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
        @include('admin.sesi.script')
    @endpush
</x-app-layout>
