<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sesi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SesiController extends Controller
{
    public $data = [
        'title' => 'sesi',
    ];

    public function index()
    {
        $this->data['sesi'] = Sesi::all();
        return view('admin.sesi.table', $this->data);
    }

    public function create()
    {
        $this->data['type'] = 'create';
        return view('admin.sesi.form', $this->data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $sesi = Sesi::create($request->all());
            DB::commit();

            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil ditambahkan!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['title' => 'Error!', 'icon' => 'error', 'text' => 'Terjadi kesalahan saat menambahkan data!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }

    public function show($id)
    {
        $sesi = Sesi::find($id);
        return view('admin.sesis.show', compact('sesi'));
    }

    public function edit($id)
    {
        $this->data['type'] = 'update';
        $this->data['sesi'] = Sesi::find($id);

        return view('admin.sesi.form', $this->data );
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $sesi = Sesi::find($request->id);
            $sesi->update([
                'nama' => $request->nama,
                'start' => $request->start,
                'end' => $request->end,
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
            $sesi = Sesi::find($id);
            $sesi->delete();
            DB::commit();

            return response()->json(['title' => 'Success!', 'icon' => 'success', 'text' => 'Data Berhasil dihapus!', 'ButtonColor' => '#66BB6A', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['title' => 'Error!', 'icon' => 'error', 'text' => 'Terjadi kesalahan saat menghapus data!', 'ButtonColor' => '#EF5350', 'type' => 'error']);
        }
    }
}
