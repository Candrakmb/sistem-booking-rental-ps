<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Sesi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public $data = [
        'title' => 'Kalender Transaksi',
        'modul' => 'kalender',
    ];

    public function transaksi()
    {
        $this->data['data'] =null;
        $this->data['rental'] = Rental::all();
        $this->data['sesi'] = Sesi::all();
        $this->data['transaksi'] = Transaksi::with('user', 'sesi', 'rental')->get();
        $this->data['event'] = array();
        foreach($this->data['transaksi'] as $transaksi){
            $this->data['event'][] = [
                'title' => $transaksi->rental->nama . ' - ' . $transaksi->sesi->nama. ' ( ' . Carbon::parse($transaksi->sesi->start)->format('H:i') .' - ' . Carbon::parse($transaksi->sesi->end)->format('H:i') . ' )',
                'start' => $transaksi->start_date,
                'end' => $transaksi->end_date,
            ];
        }
        return view('transaksi.kalender', $this->data);
    }

    public function getDataRental(Request $request)
    {
        $rental = Rental::get();

        $dataRental = $rental->filter(function ($item) use ($request) {
            $total = Transaksi::where('rental_id', $item->id)
            ->where('start_date', $request->start_date)
            ->where('end_date', $request->end_date)
            ->count();
            return ($item->jumlah - $total) != 0;
        });

        $sesi = Sesi::get();

        $dataSesi = $sesi->filter(function ($item) use ($request) {
            $cekSesiInTransaksi = Transaksi::where('sesi_id', $item->id)
            ->where('start_date', $request->start_date)
            ->where('end_date', $request->end_date)
            ->first();
            return !$cekSesiInTransaksi;
        });


        
        // return response()->json(['start_date' => $request->start_date, 'end_date' => $request->end_date,]);
        return response()->json(['dataRental' => $dataRental, 'dataSesi' => $dataSesi]);

    }

    public function calculateTotal(Request $request){
        $rental = Rental::find($request->rental_id);
        $chargeLibur = 50000;
        $hariLibur = filter_var($request->hari_libur, FILTER_VALIDATE_BOOLEAN);
        if($hariLibur){
            $total = $rental->harga + $chargeLibur;
            return response()->json(['harga_rental'=> $rental->harga, 'charge_libur' => $chargeLibur , 'total' => $total]);
        } else {
            $total = $rental->harga;
            return response()->json(['harga_rental'=> $rental->harga,
            'charge_libur' => 0, 'total' => $total]);
        }
    }

    public function store(Request $request)
    {

        DB::beginTransaction();


        try {

            $user_id = Auth::user()->id;

            $request->validate([
                'sesi' => 'required',
                'rental' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'total' => 'required',
            ]);
            $cekTransaksi = Transaksi::where('sesi_id', $request->sesi)
                ->where('start_date', $request->start_date)
                ->where('end_date', $request->end_date)
                ->where('rental_id', $request->rental)
                ->first();

            if(!$cekTransaksi){
                $transaksi = new Transaksi();
                $transaksi->user_id = $user_id;
                $transaksi->sesi_id = $request->sesi;
                $transaksi->rental_id = $request->rental;
                $transaksi->start_date = $request->start_date;
                $transaksi->end_date = $request->end_date;
                $transaksi->status_transaksi = 'chekout';
                $transaksi->status_pembayaran = 'pending';
                $transaksi->total_bayar = $request->total;
                $transaksi->save();
                DB::commit();

                $transaksi = Transaksi::with('user', 'sesi', 'rental')->find($transaksi->id);
                $title = $transaksi->rental->nama . ' - ' . $transaksi->sesi->nama. ' ( ' . Carbon::parse($transaksi->sesi->start)->format('H:i') .' - ' . Carbon::parse($transaksi->sesi->end)->format('H:i') . ' )';
                $start = $transaksi->start_date;
                $end = $transaksi->end_date;
                return response()->json(['type' => 'success','title'=> $title, 'start' => $start, 'end' => $end]);
            } else {
                DB::rollback();
                return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'maaf sesi sudah di booking!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
            }
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => 'Validasi gagal. ' . $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['title' => 'Error', 'icon' => 'error', 'text' => $e->getMessage(), 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }

    }


}
