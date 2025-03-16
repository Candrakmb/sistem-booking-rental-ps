<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MidtransApiController extends Controller
{
    public function callback(Request $request)
    {
        // dd($request->all());
        try {
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
            // dd($hashed == $request->signature_key);
            if ($hashed == $request->signature_key) {
                $transaksi = Transaksi::where('kode_booking', $request->order_id)->first();
                if ($transaksi) {
                    if ($request->transaction_status == 'capture') {
                        if ($request->payment_type == 'credit_card') {
                            if ($request->fraud_status == 'challenge') {
                                $transaksi->update(['status_pembayaran' => 'pending']);
                            } else {
                                $transaksi->update(['status_pembayaran' => 'berhasil','paid_at' => Carbon::now(), 'metode_pembayaran' => $request->payment_type,'status_transaksi' => 'dibayar']);
                            }
                        }
                    }
                    else if($request->transaction_status == 'settlement') {
                        $transaksi->update(['status_pembayaran' => 'berhasil', 'paid_at' => Carbon::now(), 'metode_pembayaran' => $request->payment_type,'status_transaksi' => 'dibayar']);
                    } else if ($request->transaction_status == 'pending') {
                        $transaksi->update(['status_pembayaran' => 'pending']);
                    } else if ($request->transaction_status == 'deny') {
                        $transaksi->update(['status_pembayaran' => 'deny','status_transaksi'=>'cencel']);
                    } else if ($request->transaction_status == 'expire') {
                        $transaksi->update(['status_pembayaran' => 'expire','status_transaksi'=>'cencel']);
                    } else if ($request->transaction_status == 'cancel') {
                        $transaksi->update(['status_pembayaran' => 'cancel', 'status_transaksi'=>'cencel']);
                    }

                    return response()
                        ->json([
                            'success' => true,
                            'message' => $transaksi,
                        ]);
                } else {
                    return response()
                        ->json([
                            'success' => false,
                            'message' => 'Order not found',
                        ], 404);
                }
            } else {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Invalid signature key',
                    ], 400);
            }
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage(),
                ], 500);
        }
    }
}
