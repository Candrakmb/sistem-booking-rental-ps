<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public $data = [
        'title' => 'report',
        'type' =>'admin'
    ];

    public function index(){
        $this->data['data'] = null;
        $this->data['transaksi'] = Transaksi::with('user', 'sesi', 'rental')->get();

        return view('riwayat.view', $this->data);
    }

    public function detailTransaksi($id)
    {
        $this->data['transaksi'] = Transaksi::with('user', 'sesi', 'rental')->find($id);
    
        if ($this->data['transaksi']) {
            return view('riwayat.rincian', $this->data);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }

}
