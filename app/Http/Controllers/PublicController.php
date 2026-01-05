<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function verifyCertificate(Request $request, $id)
    {
        // Must use ID to find certificate
        $sertifikat = \App\Models\Sertifikat::with(['user.talent'])->find($id);

        if (!$sertifikat) {
            abort(404, 'Sertifikat tidak ditemukan.');
        }

        // Ideally checking "valid" or "verified"
        // Based on user request "halaman detail sertifikat yang sudah valid"
        // Let's assume we display whatever status, but visually indicate if it's valid or not.
        
        return view('public.certificate-verification', compact('sertifikat'));
    }
}
