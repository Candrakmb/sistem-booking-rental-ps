<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public $data = [
        'title' => 'rental',
    ];

    public function index()
    {
        $this->data['rental'] = Rental::all();
        return view('admin.rental.table', $this->data);
    }

    public function create()
    {
        $this->data['type'] = 'create';
        return view('admin.rental.form', $this->data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $rental = Rental::create($request->all());
            DB::commit();

            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil ditambahkan!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['title' => 'Error!', 'icon' => 'error', 'text' => 'Terjadi kesalahan saat menambahkan data!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }

    public function show($id)
    {
        $rental = Rental::find($id);
        return view('admin.rentals.show', compact('rental'));
    }

    public function edit($id)
    {
        $this->data['type'] = 'update';
        $this->data['rental'] = Rental::find($id);

        return view('admin.rental.form', $this->data );
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $rental = Rental::find($request->id);
            $rental->update([
                'nama' => $request->nama,
                'jumlah' => $request->jumlah,
                'harga' => $request->harga,
            ]);
            DB::commit();

            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil diperbarui!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['title' => 'Error!', 'icon' => 'error', 'text' => 'Terjadi kesalahan saat memperbarui data!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $rental = Rental::find($id);
            $rental->delete();
            DB::commit();

            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil dihapus!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['title' => 'Error!', 'icon' => 'error', 'text' => 'Terjadi kesalahan saat menghapus data!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }
}
