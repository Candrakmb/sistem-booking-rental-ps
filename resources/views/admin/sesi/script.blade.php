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
                            url: "/sesi/formcreate",
                        @else
                            url: "/sesi/formupdate",
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
                                                location.href = "/sesi/table";
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


        return {
            init: function() {
                create();
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
