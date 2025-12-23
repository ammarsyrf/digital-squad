<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Sertifikat::where('user_id', Auth::id())->latest()->get();
        return view('talent.certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        \Log::info('Store Certificate Request:', $request->all());

        $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'nullable|string',
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $filePath = $request->file('file_sertifikat')->store('certificates', 'public');

            Sertifikat::create([
                'user_id' => Auth::id(),
                'nama_sertifikat' => $request->nama_sertifikat,
                'penerbit' => $request->penerbit,
                'tanggal_terbit' => $request->tanggal_terbit,
                'deskripsi' => $request->deskripsi,
                'file_path' => $filePath,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Sertifikat berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error storing certificate: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan sertifikat: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, Sertifikat $sertifikat)
    {
        if ($sertifikat->user_id !== Auth::id()) {
            abort(403);
        }

        \Log::info('Update Certificate Request:', $request->all());

        $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'nullable|string',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $data = [
                'nama_sertifikat' => $request->nama_sertifikat,
                'penerbit' => $request->penerbit,
                'tanggal_terbit' => $request->tanggal_terbit,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('file_sertifikat')) {
                // Delete old file safely
                if ($sertifikat->file_path) {
                    if (str_contains($sertifikat->file_path, '..')) {
                        \Log::warning('Legacy path detected, skipping Storage::delete: ' . $sertifikat->file_path);
                    } else {
                        Storage::disk('public')->delete($sertifikat->file_path);
                    }
                }
                $data['file_path'] = $request->file('file_sertifikat')->store('certificates', 'public');
            }

            $sertifikat->update($data);

            return redirect()->back()->with('success', 'Sertifikat berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating certificate: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui sertifikat: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        \Log::info('Destroy Certificate Request for ID: ' . $id);

        try {
            $sertifikat = Sertifikat::findOrFail($id);

            if ($sertifikat->user_id !== Auth::id()) {
                \Log::warning('Unauthorized delete attempt by User ID: ' . Auth::id() . ' for Cert ID: ' . $id);
                abort(403);
            }

            if ($sertifikat->file_path) {
                if (str_contains($sertifikat->file_path, '..')) {
                    \Log::warning('Legacy path detected, skipping Storage::delete: ' . $sertifikat->file_path);
                } else {
                    Storage::disk('public')->delete($sertifikat->file_path);
                }
            }

            $sertifikat->delete();
            \Log::info('Certificate deleted successfully ID: ' . $id);

            return redirect()->back()->with('success', 'Sertifikat berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error deleting certificate ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus sertifikat: ' . $e->getMessage()]);
        }
    }
}
