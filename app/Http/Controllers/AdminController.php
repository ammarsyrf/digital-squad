<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Sertifikat;
use App\Models\User;
use App\Models\SoalSkill;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function umkmVerification()
    {
        $umkms = Umkm::with('user')->latest()->get();
        return view('admin.verification.umkm', compact('umkms'));
    }

    public function approveUmkm($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status_verifikasi' => 'verified']);

        // Kirim Notifikasi ke UMKM
        \App\Models\Notifikasi::create([
            'user_id' => $umkm->user_id,
            'judul' => 'Akun Instansi Terverifikasi',
            'pesan' => "Selamat! Akun instansi {$umkm->nama_umkm} Anda telah berhasil diverifikasi.",
            'link' => route('umkm.profile'),
            'is_read' => false
        ]);

        // Kirim Pesan Chat Langsung ke UMKM
        \App\Models\Pesan::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $umkm->user_id,
            'pesan' => "Selamat! Akun instansi {$umkm->nama_umkm} Anda telah berhasil diverifikasi.",
            'is_read' => false
        ]);

        return redirect()->back()->with('success', "Akun {$umkm->nama_umkm} berhasil diverifikasi.");
    }

    public function rejectUmkm(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->update([
            'status_verifikasi' => 'rejected',
            'catatan_admin' => $request->catatan
        ]);

        return redirect()->back()->with('success', "Akun {$umkm->nama_umkm} telah ditolak.");
    }

    public function certificateVerification()
    {
        $sertifikats = Sertifikat::with('user.talent')->latest()->get();
        return view('admin.verification.certificates', compact('sertifikats'));
    }

    public function approveCertificate($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $sertifikat->update(['status' => 'verified']);
        return redirect()->back()->with('success', "Sertifikat {$sertifikat->nama_sertifikat} berhasil diverifikasi.");
    }

    public function rejectCertificate(Request $request, $id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $sertifikat->update([
            'status' => 'rejected'
        ]);
        // Note: certificates table might not have catatan_admin yet, skipping for now
        return redirect()->back()->with('success', "Sertifikat {$sertifikat->nama_sertifikat} telah ditolak.");
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        // Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10);

        // Statistics
        $totalUsers = User::count();
        $talentCount = User::where('role', 'talent')->count();
        $umkmCount = User::where('role', 'umkm')->count();
        $newUsersCount = User::whereDate('created_at', \Carbon\Carbon::today())->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'talentCount', 'umkmCount', 'newUsersCount'));
    }

    public function exportUsers()
    {
        $users = User::all();
        $filename = "users_export_" . date('Ymd_His') . ".csv";

        $handle = fopen('php://memory', 'w');
        fputs($handle, "\xEF\xBB\xBF"); // BOM for Excel
        fputcsv($handle, ['ID', 'Nama', 'Email', 'Role', 'Status', 'Tanggal Gabung']);

        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id_users,
                $user->name,
                $user->email,
                $user->role,
                $user->status ?? '-',
                $user->created_at,
            ]);
        }

        fseek($handle, 0);

        return response()->stream(
            function () use ($handle) {
                fpassthru($handle);
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,talent,umkm', // Adjust roles as needed
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_users . ',id_users',
            'role' => 'required|in:admin,talent,umkm',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    public function skillTests(Request $request)
    {
        $query = \App\Models\KategoriSkill::with(['soal' => function($q) {
            $q->orderByRaw("CASE WHEN kesulitan = 'mudah' THEN 1 WHEN kesulitan = 'sedang' THEN 2 WHEN kesulitan = 'sulit' THEN 3 ELSE 4 END");
        }]);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_kategori', 'like', "%$q%")
                  ->orWhereHas('soal', function($sq) use ($q) {
                      $sq->where('pertanyaan', 'like', "%$q%");
                  });
        }

        $categories = $query->withCount('soal')->latest('id_kategori_skill')->paginate(10);

        // Statistics
        $totalSoal = \App\Models\SoalSkill::count();
        $totalKategori = \App\Models\KategoriSkill::count();
        $activeSoal = \App\Models\SoalSkill::where('status', 'aktif')->count();

        return view('admin.skill_tests.index', compact('categories', 'totalSoal', 'totalKategori', 'activeSoal'));
    }

    public function createSkillTest()
    {
        $categories = \App\Models\KategoriSkill::all();
        return view('admin.skill_tests.create', compact('categories'));
    }

    public function storeSkillTest(Request $request)
    {
        $rules = [
            'kategori_id' => 'required|exists:kategori_skill,id_kategori_skill',
            'kesulitan' => 'required|in:mudah,sedang,sulit',
            'status' => 'required|in:aktif,nonaktif',
            'questions' => 'required|array|min:1',
            'questions.*.pertanyaan' => 'required|string',
            'questions.*.tipe_soal' => 'required|in:pilihan_ganda,essay',
        ];

        // Dynamic rules for each question
        if ($request->has('questions') && is_array($request->questions)) {
            foreach ($request->questions as $index => $q) {
                $rules["questions.$index.opsi_a"] = 'required_if:questions.'.$index.'.tipe_soal,pilihan_ganda';
                $rules["questions.$index.opsi_b"] = 'required_if:questions.'.$index.'.tipe_soal,pilihan_ganda';
                $rules["questions.$index.opsi_c"] = 'required_if:questions.'.$index.'.tipe_soal,pilihan_ganda';
                $rules["questions.$index.opsi_d"] = 'required_if:questions.'.$index.'.tipe_soal,pilihan_ganda';
                $rules["questions.$index.jawaban_benar"] = 'required_if:questions.'.$index.'.tipe_soal,pilihan_ganda';
                $rules["questions.$index.kunci_jawaban_essay"] = 'required_if:questions.'.$index.'.tipe_soal,essay';
            }
        }

        $messages = [
            'required_if' => 'Bidang ini wajib diisi untuk tipe soal terpilih.',
        ];
        
        $validated = $request->validate($rules, $messages);

        $commonData = [
            'kategori_id' => $request->kategori_id,
            'kesulitan' => $request->kesulitan,
            'status' => $request->status,
        ];

        $count = 0;

        foreach ($request->questions as $q) {
            $data = array_merge($commonData, $q);
            
            // Clean up data based on type
            if ($data['tipe_soal'] === 'essay') {
                $data['opsi_a'] = null;
                $data['opsi_b'] = null;
                $data['opsi_c'] = null;
                $data['opsi_d'] = null;
                $data['jawaban_benar'] = null;
            } else {
                $data['kunci_jawaban_essay'] = null;
            }

            SoalSkill::create($data);
            $count++;
        }

        return redirect()->route('admin.skill-tests')->with('success', $count . ' Soal berhasil ditambahkan.');
    }

    public function editSkillTest($id)
    {
        $soal = SoalSkill::findOrFail($id);
        $categories = \App\Models\KategoriSkill::all();
        return view('admin.skill_tests.edit', compact('soal', 'categories'));
    }

    public function updateSkillTest(Request $request, $id)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'kategori_id' => 'required|exists:kategori_skill,id_kategori_skill',
            'tipe_soal' => 'required|in:pilihan_ganda,essay',
            'opsi_a' => 'required_if:tipe_soal,pilihan_ganda',
            'opsi_b' => 'required_if:tipe_soal,pilihan_ganda',
            'opsi_c' => 'required_if:tipe_soal,pilihan_ganda',
            'opsi_d' => 'required_if:tipe_soal,pilihan_ganda',
            'jawaban_benar' => 'required_if:tipe_soal,pilihan_ganda',
            'kunci_jawaban_essay' => 'required_if:tipe_soal,essay',
            'kesulitan' => 'required|in:mudah,sedang,sulit',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $soal = SoalSkill::findOrFail($id);

        if ($request->tipe_soal === 'essay') {
            $validated['opsi_a'] = null;
            $validated['opsi_b'] = null;
            $validated['opsi_c'] = null;
            $validated['opsi_d'] = null;
            $validated['jawaban_benar'] = null;
        } else {
            $validated['kunci_jawaban_essay'] = null;
        }

        $soal->update($validated);

        return redirect()->route('admin.skill-tests')->with('success', 'Soal berhasil diperbarui.');
    }

    public function deleteSkillTest($id)
    {
        $soal = SoalSkill::findOrFail($id);
        $soal->delete();
        return redirect()->route('admin.skill-tests')->with('success', 'Soal berhasil dihapus.');
    }

    public function bulkUpdateSkillTestStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:soal_skill,id_soal_skill',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        SoalSkill::whereIn('id_soal_skill', $request->ids)->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status soal berhasil diperbarui massal.');
    }

    // --- Skill Categories CRUD ---

    public function skillCategories(Request $request)
    {
        $query = \App\Models\KategoriSkill::query();

        if ($request->filled('q')) {
            $query->where('nama_kategori', 'like', '%' . $request->q . '%');
        }

        $categories = $query->paginate(10);
        return view('admin.skill_categories.index', compact('categories'));
    }

    public function createSkillCategory()
    {
        return view('admin.skill_categories.create');
    }

    public function storeSkillCategory(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_skill,nama_kategori',
        ]);

        \App\Models\KategoriSkill::create($validated);

        return redirect()->route('admin.skill-categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function editSkillCategory($id)
    {
        $category = \App\Models\KategoriSkill::findOrFail($id);
        return view('admin.skill_categories.edit', compact('category'));
    }

    public function updateSkillCategory(Request $request, $id)
    {
        $category = \App\Models\KategoriSkill::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_skill,nama_kategori,' . $id . ',id_kategori_skill',
        ]);

        $category->update($validated);

        return redirect()->route('admin.skill-categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function deleteSkillCategory($id)
    {
        $category = \App\Models\KategoriSkill::findOrFail($id);
        // Optional: Check if used in SoalSkill before delete? 
        // For now, let's allow delete but maybe restrict in DB level or handle exception if foreign key fails.
        // Assuming no strict cascade delete or restriction logic requested yet.
        $category->delete();
        return redirect()->route('admin.skill-categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
