<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::id())->orderBy('hari')->get();

        return view('dokter.jadwal-periksa.index', compact('jadwalPeriksas'));
    }

    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        if ($this->hasScheduleConflict($validated)) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal aktif bertabrakan dengan jadwal lain pada hari yang sama.'])
                ->withInput();
        }

        JadwalPeriksa::create($validated + [
            'id_dokter' => Auth::id(),
        ]);

        return redirect()->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $jadwalPeriksa = $this->jadwalMilikDokter($id);

        return view('dokter.jadwal-periksa.edit', compact('jadwalPeriksa'));
    }

    public function update(Request $request, string $id)
    {
        $jadwalPeriksa = $this->jadwalMilikDokter($id);
        $validated = $request->validate($this->validationRules());

        if ($this->hasScheduleConflict($validated, $jadwalPeriksa->id)) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal aktif bertabrakan dengan jadwal lain pada hari yang sama.'])
                ->withInput();
        }

        $jadwalPeriksa->update($validated);

        return redirect()->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $jadwalPeriksa = $this->jadwalMilikDokter($id);
        $jadwalPeriksa->delete();

        return redirect()->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil dihapus.');
    }

    private function validationRules(): array
    {
        return [
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
        ];
    }

    private function hasScheduleConflict(array $data, ?int $ignoreId = null): bool
    {
        if ($data['status'] !== 'Aktif') {
            return false;
        }

        $query = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('hari', $data['hari'])
            ->where('status', 'Aktif')
            ->where('jam_mulai', '<', $data['jam_selesai'])
            ->where('jam_selesai', '>', $data['jam_mulai']);

        if ($ignoreId !== null) {
            $query->whereKeyNot($ignoreId);
        }

        return $query->exists();
    }

    private function jadwalMilikDokter(string $id): JadwalPeriksa
    {
        return JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);
    }
}