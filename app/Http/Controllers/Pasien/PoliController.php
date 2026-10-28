<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    public function get()
    {
        $user = Auth::user();
        $user->ensureNoRm();
        $polis = Poli::all();
        $jadwal = JadwalPeriksa::with('dokter')
            ->where('status', 'Aktif')
            ->get();

        return view('pasien.daftar', [
            'user' => $user,
            'polis' => $polis,
            'jadwals' => $jadwal,
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'id_poli' => 'required|exists:poli,id',
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'nullable|string',
            'id_pasien' => 'required|exists:users,id',
        ]);

        $jadwalSesuaiPoli = JadwalPeriksa::whereKey($validated['id_jadwal'])
            ->where('status', 'Aktif')
            ->whereHas('dokter', function ($query) use ($validated) {
                $query->where('id_poli', $validated['id_poli']);
            })
            ->exists();

        if (!$jadwalSesuaiPoli) {
            return back()
                ->withErrors(['id_jadwal' => 'Pilih jadwal aktif yang sesuai dengan poli.'])
                ->withInput();
        }

        $jumlahSudahDaftar = DaftarPoli::where('id_jadwal', $validated['id_jadwal'])->count();

        DaftarPoli::create([
            'id_pasien' => $validated['id_pasien'],
            'id_jadwal' => $validated['id_jadwal'],
            'keluhan' => $validated['keluhan'] ?? null,
            'no_antrian' => $jumlahSudahDaftar + 1,
        ]);

        return redirect()
            ->back()
            ->with('message', 'Berhasil Mendaftar ke Poli')
            ->with('type', 'success');
    }
}