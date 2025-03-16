<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    var data = function() {
        let valid = true, real='', message = '', title = '', type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

        var datakalender = function(transaksi){
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: transaksi,
                select: function(info) {
                    document.getElementById('modalDate').innerText = 'Booking pada ' + info.startStr;
                    // Get the date from the clicked day
                    var start_date = moment(info.start).format('YYYY-MM-DD');
                    var end_date = moment(info.end).format('YYYY-MM-DD');
                    var formData = {
                        start_date: start_date,
                        end_date: end_date
                    };
                    $.ajax({
                        url: '/getDataRentalSesi',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('input[name="start_date"]').val(start_date);
                            $('input[name="end_date"]').val(end_date);
                            var $selectRental = $('select[name="rental"]');
                            $selectRental.empty();
                            $selectRental.append('<option selected disabled value="">Pilih...</option>');
                            $.each(response.dataRental, function(index, item) {
                                $selectRental.append('<option value="' + item.id + '">' + item.nama.toUpperCase() + '</option>');
                            });

                            var $selectSesi = $('select[name="sesi"]');
                            $selectSesi.empty();
                            $selectSesi.append('<option selected disabled value="">Pilih...</option>');
                            $.each(response.dataSesi, function(index, item) {
                                var startTime = item.start.split(':').slice(0, 2).join(':'); // "HH:mm"
                                var endTime = item.end.split(':').slice(0, 2).join(':');     // "HH:mm"
                                $selectSesi.append('<option value="' + item.id + '">' + item.nama.toUpperCase() + ' (' + startTime + ' - ' + endTime + ')</option>');
                            });

                            $('#dateModal').modal('show');
                        }
                    });

                    create();
                    calculateTotal(info.startStr);

                },
                selectAllow: function(selectInfo) {
                    let today = moment().format('YYYY-MM-DD'); // Ambil tanggal hari ini
                    let startDate = moment(selectInfo.start).format('YYYY-MM-DD');
                    let endDate = moment(selectInfo.end).subtract(1, 'second').format('YYYY-MM-DD');

                    // Cek apakah tanggal yang dipilih lebih kecil dari hari ini atau sama dengan hari ini
                    if (startDate <= today) {
                        return false;
                    }

                    // Pastikan hanya satu tanggal yang bisa dipilih (bukan rentang)
                    return startDate === endDate;
                },
                eventClick: function(info) {
                    $.ajax({
                        url: '/transaksi/detail/' + info.event.id,
                        type: 'GET',
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.status == 'success'){
                                console.log(response);
                                var sesiStart = moment(response.transaksi.sesi.start, 'HH:mm:ss').format('HH:mm');
                                var sesiEnd = moment(response.transaksi.sesi.end, 'HH:mm:ss').format('HH:mm');
                                $('#detailTransaksi').modal('show');
                                document.getElementById('kode_booking').innerText = 'Kode Booking ' + response.transaksi.kode_booking;
                                $('#detail_harga').text(formatRupiah(response.transaksi.rental.harga));
                                $('#detail_charge').text(formatRupiah(response.transaksi.charge));
                                $('#detail_total').text(formatRupiah(response.transaksi.total_bayar));
                                $('#rincian_status').text(response.transaksi.status_transaksi);
                                $('#date').text(response.transaksi.formatted_tanggal);
                                $('#rincian_sesi').text(response.transaksi.sesi.nama + ' (' + sesiStart + ' - ' + sesiEnd + ')');
                                $('#rincian_rental').text(response.transaksi.rental.nama);
                                $('#rincian_pembayaran').text(response.transaksi.status_pembayaran);
                                if(response.transaksi.status_pembayaran == 'pending' && response.transaksi.status_transaksi == 'chekout'){
                                    $('#bayar').click(function(e) {
                                    e.preventDefault();
                                    payMidtrans(response.transaksi.snap_token);
                                    });
                                } else {
                                    $('#bayar').hide();
                                }
                            }else{
                                    swal.fire({
                                        title: response.title,
                                        text : response.text,
                                        confirmButtonColor: response.ButtonColor,
                                        type : response.type,
                                    });
                            }
                            console.log(response);
                        }
                    });
                }
            });

            calendar.render();
        }

        var viewKalender = function() {
            var transaksi = @json($event);
            datakalender(transaksi);
        }

        var create = function() {
            $('#simpan').click(function(e) {
            e.preventDefault();

            // Validasi inputan
            var valid = true;
            var err = 0;
            $('.help-block').hide();
            $('.form-error').removeClass('form-error');
            $('#form-data').find('select').each(function () {
                console.log($(this).val());
            if ($(this).prop('required') && $(this).val() == null) {
                if (err === 0) { // Hanya ambil error pertama
                    valid = false;
                    real = this.name;
                    title = $('label[for="' + this.name + '"]').html() || this.name;
                    type = 'dipilih';
                    err++; // Set error agar tidak menimpa nilai sebelumnya
                }

                // Tambahkan error styling untuk semua elemen yang salah
                $(this).closest('div').find('.select2-selection--single').addClass('form-error');
                $(this).closest('div').find('.help-block').html(title + ' belum ' + type).show();
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
                        url: '/transaksi/create',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.type == 'success'){
                                $('#dateModal').modal('hide');
                                payMidtrans(response.snap_token);
                                console.log(response);
                                datakalender(response.event);
                            }else{
                                    swal.fire({
                                        title: response.title,
                                        text : response.text,
                                        confirmButtonColor: response.ButtonColor,
                                        type : response.type,
                                    });
                            }
                            console.log(response);
                        }
                    });
                }

            });
        }

        var calculateTotal = function(date) {
            var date = new Date(date);
            var day = date.getDay();
            console.log(date);
            $('select[name="rental"]').change(function(e) {
                var id = $(this).val();
                var libur = false;
                if(day === 0 || day === 6) {
                    libur = true;
                }
                console.log(libur);
                var formData = {
                    rental_id: id,
                    hari_libur: libur
                };
                $.ajax({
                    url: '/calculateTotal',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('.view_harga').text(formatRupiah(response.harga_rental));
                        $('.view_charge').text(formatRupiah(response.charge_libur));
                        $('.total').text(formatRupiah(response.total));
                        $('input[name="total"]').val(response.total);
                    }
                });
            })
        }


        var payMidtrans = function(snaptoken) {
            snap.pay(snaptoken, {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    //buat menuju ke /transaksi/berhasil
                    window.location.href = "/transaksi/berhasil";
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        }

        $('#dateModal').on('hidden.bs.modal', function() {
            $('.help-block').hide();
            $('.form-error').removeClass('form-error');
            $('.view_harga').text('Rp0');
            $('.view_charge').text('Rp0');
            $('.total').text('Rp0');
            $('#form-data').trigger('reset');
            $('#simpan').unbind();
        });

        $('#detailTransaksi').on('hidden.bs.modal', function() {
            $('#detail_harga').text('');
            $('#detail_charge').text('');
            $('#detail_total').text('');
            $('#bayar').show();
        });

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        return {
            init: function() {
                viewKalender();
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
