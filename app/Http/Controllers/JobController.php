<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // UMKM Methods
    public function umkmIndex(Request $request)
    {
        $query = Auth::user()->umkm->lowongan();

        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function ($sql) use ($q) {
                $sql->where('judul', 'like', "%$q%")
                    ->orWhere('deskripsi', 'like', "%$q%");
            });
        }

        $jobs = $query->latest()->get();
        return view('umkm.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('umkm.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_pekerjaan' => 'required|string',
            'lokasi' => 'required|string',
            'gaji' => 'nullable|string',
        ]);

        $validated['umkm_id'] = Auth::user()->umkm->id;
        $validated['status'] = 'Aktif';

        Lowongan::create($validated);

        return redirect()->route('umkm.jobs')->with('success', 'Lowongan berhasil dipublikasikan!');
    }

    public function edit(Lowongan $lowongan)
    {
        return view('umkm.jobs.edit', compact('lowongan'));
    }

    public function update(Request $request, Lowongan $lowongan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_pekerjaan' => 'required|string',
            'lokasi' => 'required|string',
            'gaji' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $lowongan->update($validated);

        return redirect()->route('umkm.jobs')->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();
        return redirect()->route('umkm.jobs')->with('success', 'Lowongan berhasil dihapus!');
    }

    public function applicants()
    {
        $umkmId = Auth::user()->umkm->id;
        $applicants = Lamaran::whereHas('lowongan', function ($q) use ($umkmId) {
            $q->where('umkm_id', $umkmId);
        })->with(['talent.user', 'lowongan'])->latest()->get();

        return view('umkm.applicants.index', compact('applicants'));
    }

    public function updateApplicantStatus(Request $request, Lamaran $lamaran)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Pending,Interview,Diterima,Ditolak',
        ]);

        $lamaran->update($validated);

        return redirect()->back()->with('success', 'Status lamaran berhasil diperbarui!');
    }

    // Talent Methods
    public function talentIndex(Request $request)
    {
        $query = Lowongan::with('umkm')->where('status', 'Aktif');

        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function ($sql) use ($q) {
                $sql->where('judul', 'like', "%$q%")
                    ->orWhere('deskripsi', 'like', "%$q%")
                    ->orWhereHas('umkm', function ($sub) use ($q) {
                        $sub->where('nama_instansi', 'like', "%$q%");
                    });
            });
        }

        $jobs = $query->latest()->get();
        return view('talent.jobs.index', compact('jobs'));
    }

    public function show(Lowongan $lowongan)
    {
        $lowongan->load('umkm');
        $talent = Auth::user()->talent;
        $hasApplied = $talent ? Lamaran::where('talent_id', $talent->id)->where('lowongan_id', $lowongan->id)->exists() : false;
        return view('talent.jobs.show', compact('lowongan', 'hasApplied'));
    }

    public function apply(Lowongan $lowongan)
    {
        $talent = Auth::user()->talent;
        if (!$talent) {
            return redirect()->back()->with('error', 'Lengkapi profil talenta Anda terlebih dahulu.');
        }

        if (Lamaran::where('talent_id', $talent->id)->where('lowongan_id', $lowongan->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah melamar pekerjaan ini.');
        }

        Lamaran::create([
            'talent_id' => $talent->id,
            'lowongan_id' => $lowongan->id,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Lamaran Anda berhasil dikirim!');
    }

    public function talentApplications()
    {
        $talent = Auth::user()->talent;
        $applications = $talent ? $talent->lamaran()->with('lowongan.umkm')->latest()->get() : collect();
        return view('talent.applications.index', compact('applications'));
    }
}
