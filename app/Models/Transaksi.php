<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode_booking','user_id', 'sesi_id','rental_id', 'status_transaksi','start_date','end_date','status_pembayaran','metode_pembayaran', 'total_bayar', 'snap_token', 'paid_at'];
    protected $appends = ['charge', 'formatted_tanggal', 'formatted_sesi'];


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

    //buat atribut baru menghitung charge
    public function getChargeAttribute()
    {
        $cekCharge = $this->total - $this->rental->harga;

        if($cekCharge = 0){
            return 0;
        } else {
            return 50000;
        }
    }

    public function getFormattedTanggalAttribute()
    {
        return date('d F Y', strtotime($this->attributes['start_date']));
    }

    public function getFormattedSesiAttribute(){
        return $this->sesi->nama . ' (' . date('H:i', strtotime($this->sesi->start)) . '-' . date('H:i', strtotime($this->sesi->end)) . ')';
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
