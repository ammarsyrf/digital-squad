<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Talent;
use App\Models\Umkm;

class ProfileController extends Controller
{
    public function talent()
    {
        $talent = Auth::user()->talent;
        if (!$talent) {
            $talent = Talent::create(['user_id' => Auth::id(), 'nama_lengkap' => Auth::user()->name]);
        }
        return view('talent.profile', compact('talent'));
    }

    public function updateTalent(Request $request)
    {
        $talent = Auth::user()->talent;

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'hobi' => 'nullable|string',
            'pekerjaan_saat_ini' => 'nullable|string',
            'pengalaman_kerja' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'skill' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'portfolio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($talent->foto) {
                Storage::delete('public/' . $talent->foto);
            }
            $path = $request->file('foto')->store('profiles', 'public');
            $validated['foto'] = $path;
        }

        $talent->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function umkm()
    {
        $umkm = Auth::user()->umkm;
        if (!$umkm) {
            $umkm = Umkm::create([
                'user_id' => Auth::id(),
                'nama_umkm' => Auth::user()->name ?? 'Nama Instansi',
                'status_verifikasi' => 'Belum Terverifikasi'
            ]);
        }
        return view('umkm.profile', compact('umkm'));
    }

    public function showUmkm(Umkm $umkm)
    {
        return view('talent.umkm_profile', compact('umkm'));
    }

    public function updateUmkm(Request $request)
    {
        $umkm = Auth::user()->umkm;

        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email_instansi' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dokumen_verifikasi' => 'nullable|file|mimes:pdf,jpg,png|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('logo')) {
            if ($umkm->logo) {
                Storage::delete('public/' . $umkm->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Handle Document Upload
        if ($request->hasFile('dokumen_verifikasi')) {
            if ($umkm->dokumen_verifikasi) {
                Storage::delete('public/' . $umkm->dokumen_verifikasi);
            }
            $path = $request->file('dokumen_verifikasi')->store('documents/umkm', 'public');
            $validated['dokumen_verifikasi'] = $path;
            
            // Auto-request verification / reset status if not already verified
            if ($umkm->status_verifikasi != 'verified') {
                $validated['status_verifikasi'] = 'pending'; // Reset to pending for Admin review
            }
        }

        $umkm->update($validated);

        return redirect()->back()->with('success', 'Profil instansi berhasil diperbarui!');
    }

    public function admin()
    {
        return view('admin.profile');
    }

    public function settings()
    {
        $role = Auth::user()->role;
        if ($role == 'talent') {
            return view('talent.settings');
        } elseif ($role == 'umkm') {
            return view('umkm.settings');
        }
        return view('settings.index'); // Admin/Default
    }
}
