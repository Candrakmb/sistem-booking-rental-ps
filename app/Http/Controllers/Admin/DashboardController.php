<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Sesi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $data = [
        'title' => 'dasboard',
    ];

    public function index(){

        $this->data['data']=null;

        $admin = Auth::user()->id;
        $this->data['transaksi'] = Transaksi::where('status_transaksi', 'selesai')->count();
        $this->data['user'] = User::whereNot('id', $admin)->count();
        $this->data['rental'] = Rental::count();
        $this->data['sesi']= Sesi::count();

        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('admin.dashboard', $this->data);
        
        
    }
}
