
<script>
    var data = function() {
        let valid = true, real='', message = '', title = '', type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

        var viewKalender = function() {

            var calendarEl = document.getElementById('calendar');
            var transaksi = @json($event);
            console.log(transaksi);
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
                    calculateTotal(info.dateStr);
                    // Set the date in the modal
                    
                    //tampilkan start date dan end date
                    // document.getElementById('modalDate').innerText = 'Date: ' + info.event.start + ' - ' + info.event.end;
                    // Show the modal
                    
                },
                selectAllow: function(selectInfo) {
                        // Ambil tanggal mulai dan tanggal akhir
                        let startDate = moment(selectInfo.start).format('YYYY-MM-DD');
                        let endDate = moment(selectInfo.end).subtract(1, 'second').format('YYYY-MM-DD');

                        // Periksa apakah tanggal mulai dan tanggal akhir sama
                        return startDate === endDate;
                },
                validRange: {
                    start: moment().format('YYYY-MM-DD') // Hanya bisa pilih mulai hari ini ke depan
                }
            });

            calendar.render();

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
                                $('#calender').fullCalender('renderEvent',{
                                    title: response.title,
                                    start: response.start,
                                    end: response.end,
                                });
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
            $('select[name="rental"]').change(function(e) {
                var id = $(this).val();
                var libur = false;
                if(day === 0 || day === 6) {
                    libur = true;
                }
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

        $('#dateModal').on('hidden.bs.modal', function() {
            $('.help-block').hide();
            $('.form-error').removeClass('form-error');
            $('.view_harga').text('Rp0');
            $('.view_charge').text('Rp0');
            $('.total').text('Rp0');
            $('#form-data').trigger('reset');
            $('#simpan').unbind();
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
