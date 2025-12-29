<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Sertifikat;
use App\Models\User;
use App\Models\SoalSkill;

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
                $user->id,
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
            'email' => 'required|email|unique:users,email,' . $user->id,
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
        $query = SoalSkill::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('pertanyaan', 'like', "%$q%")
                ->orWhere('soal', 'like', "%$q%") // Backwards compatibility if 'soal' column exists
                ->orWhereHas('kategori', function ($sq) use ($q) {
                    $sq->where('nama_kategori', 'like', "%$q%");
                });
        }

        $tests = $query->latest()->paginate(10);

        // Statistics
        $totalSoal = \App\Models\SoalSkill::count();
        $totalKategori = \App\Models\KategoriSkill::count();
        $activeSoal = \App\Models\SoalSkill::where('status', 'aktif')->count();

        return view('admin.skill_tests.index', compact('tests', 'totalSoal', 'totalKategori', 'activeSoal'));
    }

    public function createSkillTest()
    {
        $categories = \App\Models\KategoriSkill::all();
        return view('admin.skill_tests.create', compact('categories'));
    }

    public function storeSkillTest(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'kategori_id' => 'required|exists:kategori_skill,id',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'kesulitan' => 'required|in:mudah,sedang,sulit',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        SoalSkill::create($validated);

        return redirect()->route('admin.skill-tests')->with('success', 'Soal berhasil ditambahkan.');
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
            'kategori_id' => 'required|exists:kategori_skill,id',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D',
            'kesulitan' => 'required|in:mudah,sedang,sulit',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $soal = SoalSkill::findOrFail($id);
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
            'ids.*' => 'exists:soal_skill,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        SoalSkill::whereIn('id', $request->ids)->update(['status' => $request->status]);

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
            'nama_kategori' => 'required|string|max:255|unique:kategori_skill,nama_kategori,' . $id,
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
