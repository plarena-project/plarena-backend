<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        return Pesanan::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'lapangan' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'status' => 'required|in:DP,Lunas',
        ]);

        return Pesanan::create($data);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $data = $request->validate([
            'nama' => 'string',
            'lapangan' => 'string',
            'tanggal' => 'date',
            'jam' => 'string',
            'status' => 'in:DP,Lunas',
        ]);

        $pesanan->update($data);

        return $pesanan;
    }

    public function destroy($id)
    {
        return Pesanan::destroy($id);
    }
}
