<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public $data = [
        'title' => 'Riwayat Transaksi',
        'modul' => 'riwayat',
    ];

    public function riwayat()
    {
        $user_id = Auth::user()->id;
        $this->data['data'] = null;
        $this->data['transaksi'] = Transaksi::with('user', 'sesi', 'rental')->where('user_id', $user_id)->get();
        return view('riwayat.view', $this->data);
    }

    public function detailTransaksi($id)
    {
        $user_id = Auth::user()->id;
        $transaksi = Transaksi::with('user', 'sesi', 'rental')->find($id);
        if($transaksi->user_id != $user_id){
            return response()->json(['status' => 'error', 'message' => 'tidak memiliki akses']);
        }
        if ($transaksi) {
            return response()->json(['transaksi' => $transaksi, 'status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }
}
