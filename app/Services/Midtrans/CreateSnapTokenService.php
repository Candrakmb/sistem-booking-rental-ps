<?php

namespace App\Services\Midtrans;

use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $transaksi;

    public function __construct($transaksi)
    {
        parent::__construct();

        $this->transaksi = $transaksi;
    }

    public function getSnapToken()
    {
        $user = Auth::user();
        // dd($this->transaksi);
        $rental = Rental::where('id',$this->transaksi->rental_id)->first();


        $params = [
            'transaction_details' => [
                'order_id' => $this->transaksi->kode_booking,
                'gross_amount' => $this->transaksi->total_bayar,
            ],
            'item' => [
                'id' => $rental->id,
                'name' => $rental->nama,
                'price' => $rental->harga,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
