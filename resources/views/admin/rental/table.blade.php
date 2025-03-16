<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Riwayat') }}
        </h2>
    </x-slot>

    <div class="py-12">
       
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3">
                <a href="{{ route('rental.create') }}" class="btn btn-primary">Tambah</a>   
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rental</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rental as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>{{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('rental.edit', $data->id) }}" class="btn btn-primary">edit</a>
                                    <button type="button" class="btn btn-danger" id="btn-hapus" data-id="{{$data->id}}" >Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@push('after-script')
<script>
    var data = function() {
        let valid = true, real='', message = '', title = '', type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

        var hapus = function() {
            $('#table').on('click', '#btn-hapus', function() {
                var id = $(this).data(id);
                console.log(id.id)
                swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'Menghapus Data Ini',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2196F3',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "/rental/delete/" + id.id,
                                type: "GET",
                                contentType: false,
                                processData: false,
                                success: function(result) {
                                    swal.fire({
                                        title: result.title,
                                        text: result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type: result.type,
                                    });
                                    if (result.type == 'success') {
                                        swal.fire({
                                            title: result.title,
                                            text: result.text,
                                            confirmButtonColor: result.ButtonColor,
                                            type: result.type,
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    } else {
                                        swal.fire({
                                            title: result.title,
                                            text: result.text,
                                            confirmButtonColor: result.ButtonColor,
                                            type: result.type,
                                        });
                                    }
                                }
                            });
                        } else {
                            swal.fire({
                                text: 'Aksi Dibatalkan!',
                                type: "info",
                                confirmButtonColor: "#EF5350",
                            });
                        }
                    });
            });
        }

        return {
            init: function() {
                hapus();
            }
        }
    }();
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.fn.dataTable.ext.errMode = 'none';
        data.init();
    });
</script>
@endpush
</x-app-layout>
