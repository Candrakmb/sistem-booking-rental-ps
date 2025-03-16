<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    var data = function() {
        let valid = true, real='', message = '', title = '', type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();


        var create = function() {
            $('#simpan').click(function(e) {
            e.preventDefault();

            var valid = true;
            var err = 0;
            $('.help-block').hide();
            $('.form-error').removeClass('form-error');
            $('#form-data').find('input').each(function () {
            console.log($(this).val());
            if ($(this).prop('required') && $(this).val() == '') {
                if (err === 0) { // Hanya ambil error pertama
                    valid = false;
                    real = this.name;
                    title = $('label[for="' + this.name + '"]').html() || this.name;
                    type = 'diisi';
                    err++; // Set error agar tidak menimpa nilai sebelumnya
                }
                // Tambahkan error styling untuk semua elemen yang salah
                $("input[name=" + real + "]").addClass('form-error');
                $($("input[name=" + real + "]").closest('div').find(
                                        '.help-block')).html(title + 'belum ' + type);
                $($("input[name=" + real + "]").closest('div').find(
                                        '.help-block')).show();
                }
            });
             if (!valid) {
                swal.fire({
                    text: title + ' belum ' + type,
                    icon: "error",
                    confirmButtonColor: "#EF5350",
                });
                } else {
                    var formData = new FormData($('#form-data')[0]);
                    $.ajax({
                        @if ($type == 'create')
                            url: "/rental/formcreate",
                        @else
                            url: "/rental/formupdate",
                        @endif
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result.type == 'success') {
                                    swal.fire({
                                        title: result.title,
                                        text: result.text,
                                        confirmButtonColor: result
                                                    .ButtonColor,
                                        type: result.type,
                                    }).then((result) => {
                                                location.href = "/rental/table";
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
                }

            });
        }

        var hapus = function() {
            $('#hapus').click(function(e) {
                var id = $(this).data(id);
                console.log(id)
                e.preventDefault();
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
                            var fd = new FormData();
                            fd.append('_token', '{{ csrf_token() }}');
                            fd.append('id', data.id);

                            $.ajax({
                                url: "/paket/deleteform",
                                type: "POST",
                                data: fd,
                                dataType: "json",
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    swal.fire({
                                        html: '<h5>Loading...</h5>',
                                        showConfirmButton: false
                                    });
                                },
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
                                            $('#table').DataTable().ajax.reload();
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
                create();
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
