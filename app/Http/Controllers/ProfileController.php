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
            'umur' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'hobi' => 'nullable|string',
            'pekerjaan_saat_ini' => 'nullable|string',
            'pengalaman_kerja' => 'nullable|array',
            'pengalaman_kerja.*' => 'string|max:1000',
            'pendidikan_terakhir' => 'nullable|array', // Allow array
            'pendidikan_terakhir.*' => 'string|max:255', // Validate items
            'skill' => 'nullable|array',
            'skill.*' => 'string|max:100',
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

        // Handle multiple education entries
        if (isset($validated['pendidikan_terakhir']) && is_array($validated['pendidikan_terakhir'])) {
            $validated['pendidikan_terakhir'] = implode('; ', array_filter($validated['pendidikan_terakhir']));
        }

        // Handle multiple work experience entries
        if (isset($validated['pengalaman_kerja']) && is_array($validated['pengalaman_kerja'])) {
            $validated['pengalaman_kerja'] = implode('; ', array_filter($validated['pengalaman_kerja']));
        }

        // Handle multiple skills
        if (isset($validated['skill']) && is_array($validated['skill'])) {
            $validated['skill'] = implode('; ', array_filter($validated['skill']));
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
            // Business Info
            'kategori' => 'nullable|string',
            'skala_usaha' => 'nullable|string',
            'tahun_berdiri' => 'nullable|integer',
            'jumlah_karyawan' => 'nullable|string',
            // Branding
            'instagram' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'galeri' => 'nullable|array',
            'galeri.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            // Legal
            'npwp' => 'nullable|string',
            'nama_penanggung_jawab' => 'nullable|string',
            'jabatan_penanggung_jawab' => 'nullable|string',
            
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dokumen_verifikasi' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            if ($umkm->logo) {
                Storage::delete('public/' . $umkm->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        // Handle Gallery Upload (Append to existing)
        if ($request->hasFile('galeri')) {
            $currentGallery = json_decode($umkm->galeri ?? '[]', true);
            if (!is_array($currentGallery)) $currentGallery = [];

            foreach ($request->file('galeri') as $image) {
                $currentGallery[] = $image->store('umkm_gallery', 'public');
            }
            $validated['galeri'] = json_encode($currentGallery);
        } else {
            // Keep existing gallery if no new files uploaded (and not explicitly clearing)
            // But strict update might overwrite with null if not handled? 
            // validate returns only validated fields. if 'galeri' is not in request, it won't be in $validated.
            // If it IS in request but null? 
            // We should be careful. Laravel's validate returns provided fields. 
            // If input file is empty, it might not send 'galeri'.
            // However, to be safe, we unset it from validated if it's not a file upload to avoid overwriting with null/empty if that happens.
            unset($validated['galeri']);
            if ($request->hasFile('galeri')) { // Re-check to be sure logic flow is correct
                 // Already handled above
            }
        }
        
        // Re-assign logic for clarify:
        if ($request->hasFile('galeri')) {
             $currentGallery = json_decode($umkm->galeri ?? '[]', true);
             if (!is_array($currentGallery)) $currentGallery = [];
             foreach ($request->file('galeri') as $image) {
                 $currentGallery[] = $image->store('umkm_gallery', 'public');
             }
             $validated['galeri'] = json_encode($currentGallery);
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
