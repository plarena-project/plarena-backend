<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;

class LapanganController extends Controller
{
    public function index()
    {
        return Lapangan::all();
    }

    public function store(Request $request)
    {
        \Log::info('Request input:', $request->all());

        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image',
        ]);

        $lapangan = new Lapangan();
        $lapangan->nama = $request->nama;
        $lapangan->harga = $request->harga;
        $lapangan->keterangan = $request->keterangan;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('lapangan', 'public');
            $lapangan->foto = $path;
        }

        $lapangan->save();

        return response()->json($lapangan, 201);
    }

    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|string',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        $lapangan->update($data);
        return $lapangan;
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        $lapangan->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
