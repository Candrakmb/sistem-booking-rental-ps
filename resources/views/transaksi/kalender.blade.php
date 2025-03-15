<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Rental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal create transaksi-->
    <div class="modal" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center mb-3">
                            <p class="fw-bold" id="modalDate"></p>
                        </div>
                        <div class="col-md-12">
                            <form id="form-data" method="post" action="" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="start_date"></input>
                                        <input type="hidden" name="end_date"></input>
                                        <div class="col-md-12 mb-3">
                                            <label for="rental" class="form-label required">Rental</label>
                                            <select class="form-select select rental" name="rental" required>
                                                <option selected disabled value="">Pilih...</option>
                                            </select>
                                            <p class="help-block" style="display: none; color: red;"></p>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="sesi" class="form-label required">Sesi</label>
                                            <select class="form-select select sesi" name="sesi" required>
                                                <option selected disabled value="">Pilih...</option>
                                            </select>
                                            <p class="help-block" style="display: none; color: red;"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 text-center mb-3">
                                            <p class="fw-bold">Rincian Pembayaran</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row mb-2">

                                                <div class="col-md-6">Harga</div>
                                                <div class="col-md-6 text-end">
                                                    <span class="view_harga">Rp 0</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-6">Hari libur</div>
                                                <div class="col-md-6 text-end">
                                                    <span class="view_charge">Rp 0</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <input type="hidden" name="total"></input>
                                                <div class="col-md-6"><strong>Total</strong></div>
                                                <div class="col-md-6 text-end">
                                                    <strong><span class="total">Rp 0</span></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="button" class="btn btn-primary" id="simpan">
                                            Bayar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal detail transaksi-->
    <div class="modal" id="detailTransaksi" tabindex="-1" aria-labelledby="detailTransaksiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dateModalLabel">Rincian Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center mb-3">
                                <p class="fw-bold" id="kode_booking"></p>
                            </div>
                            <div class="col-md-12 text-end mb-3">
                                <span id="date" class="fw-bold">
                                </span>
                            </div>
                            <div class="col-md-12 text-start mb-3">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <p>Rental : <span id="rincian_rental"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Sesi : <span id="rincian_sesi"></span></p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <p>Status : <span id="rincian_status"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Status Pembayaran : <span id="rincian_pembayaran"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 text-center mb-3">
                                    <p class="fw-bold">Rincian Pembayaran</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mb-2">

                                        <div class="col-md-6">Harga</div>
                                        <div class="col-md-6 text-end">
                                            <span id="detail_harga"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Hari libur</div>
                                        <div class="col-md-6 text-end">
                                            <span id="detail_charge"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6"><strong>Total</strong></div>
                                        <div class="col-md-6 text-end">
                                            <strong><span id="detail_total"></span></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <div class="row">
                                        <div class="d-grid gap-2 mt-3">
                                            <button type="button" class="btn btn-primary" id="bayar">
                                                Bayar
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @push('after-script')
        @include('transaksi.script')
    @endpush
</x-app-layout>
