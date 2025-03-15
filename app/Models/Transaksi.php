<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode_booking','user_id', 'sesi_id','rental_id', 'status_transaksi','start_date','end_date','status_pembayaran','metode_pembayaran', 'total_bayar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $date = date('dmY');
            $tipeTransaksi = strtoupper($model->rental->nama);
            $model->kode_booking = $tipeTransaksi .'-'. $date . strtoupper(substr(uniqid(), -5));
        });
    }
}
