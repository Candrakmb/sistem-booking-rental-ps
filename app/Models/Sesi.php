<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    protected $fillable = ['nama', 'start', 'end'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
