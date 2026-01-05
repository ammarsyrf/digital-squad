<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Talent;
use App\Models\Umkm;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Sertifikat;
use App\Models\KategoriSkill;
use App\Models\SoalSkill;
use App\Models\HasilTes;

class DashboardController extends Controller
{
    public function admin()
    {
        // 1. Basic Counts
        $totalTalent = \App\Models\User::where('role', 'talent')->count();
        $totalUmkm = Umkm::count();
        $totalLowongan = Lowongan::where('status', 'aktif')->count();
        $pendingSertifikat = Sertifikat::where('status', 'pending')->count();
        $pendingUmkm = Umkm::where('status_verifikasi', 'pending')->count();

        // 2. Growth Calculation (Current Month vs Last Month)
        $now = \Carbon\Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Talent Growth (Based on User creation)
        $talentThisMonth = \App\Models\User::where('role', 'talent')->where('created_at', '>=', $startOfMonth)->count();
        $talentLastMonth = \App\Models\User::where('role', 'talent')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $talentGrowth = $talentLastMonth > 0 ? (($talentThisMonth - $talentLastMonth) / $talentLastMonth) * 100 : 100;

        // UMKM Growth
        $umkmThisMonth = Umkm::where('created_at', '>=', $startOfMonth)->count();
        $umkmLastMonth = Umkm::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $umkmGrowth = $umkmLastMonth > 0 ? (($umkmThisMonth - $umkmLastMonth) / $umkmLastMonth) * 100 : 100;

        // Lowongan Growth
        $lowonganThisMonth = Lowongan::where('created_at', '>=', $startOfMonth)->count();
        $lowonganLastMonth = Lowongan::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $lowonganGrowth = $lowonganLastMonth > 0 ? (($lowonganThisMonth - $lowonganLastMonth) / $lowonganLastMonth) * 100 : 100;

        // Specific Stats
        $talentToday = \App\Models\User::where('role', 'talent')->whereDate('created_at', \Carbon\Carbon::today())->count();

        $stats = [
            'total_talent' => $totalTalent,
            'total_umkm' => $totalUmkm,
            'total_lowongan' => $totalLowongan,
            'pending_sertifikat' => $pendingSertifikat,
            'pending_umkm' => $pendingUmkm,
            'talent_growth' => round($talentGrowth),
            'umkm_growth' => round($umkmGrowth),
            'lowongan_growth' => round($lowonganGrowth),
            'talent_today' => $talentToday,
            'talent_month' => $talentThisMonth,
        ];

        // Fetch recent activities
        $activities = collect();

        $newCerts = Sertifikat::with('user')->latest()->take(5)->get()->map(function($item){
            return [
                'type' => 'certificate',
                'message' => ($item->user->name ?? 'User') . ' mengunggah sertifikat ' . $item->nama_sertifikat,
                'time' => $item->created_at,
                'icon' => 'card_membership',
                'color' => 'blue'
            ];
        });

        $newUmkms = Umkm::with('user')->latest()->take(5)->get()->map(function($item){
            return [
                'type' => 'umkm',
                'message' => 'UMKM Baru: ' . $item->nama_umkm . ' mendaftar',
                'time' => $item->created_at,
                'icon' => 'store',
                'color' => 'emerald'
            ];
        });

        // Use User model for new talents
        $newTalents = \App\Models\User::where('role', 'talent')->latest()->take(5)->get()->map(function($item){
            return [
                'type' => 'talent',
                'message' => 'Talenta Baru: ' . $item->name . ' bergabung',
                'time' => $item->created_at,
                'icon' => 'person_add',
                'color' => 'indigo'
            ];
        });

        $newJobs = Lowongan::with('umkm')->latest()->take(5)->get()->map(function($item){
            return [
                'type' => 'job',
                'message' => 'Lowongan Baru: ' . $item->judul . ' di ' . ($item->umkm->nama_umkm ?? 'UMKM'),
                'time' => $item->created_at,
                'icon' => 'work_outline',
                'color' => 'orange'
            ];
        });

        $activities = $activities->merge($newCerts)
                                 ->merge($newUmkms)
                                 ->merge($newTalents)
                                 ->merge($newJobs)
                                 ->sortByDesc('time')
                                 ->take(10);

        // Chart Statistics
        $endDate = \Carbon\Carbon::now();
        
        // 1. Data for 30 Days (covering 7 days as well)
        $startDate30 = $endDate->copy()->subDays(29);
        $period30 = \Carbon\CarbonPeriod::create($startDate30, $endDate);
        
        $sertifikat30 = Sertifikat::where('created_at', '>=', $startDate30)->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });
        $umkm30 = Umkm::where('created_at', '>=', $startDate30)->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data30Days = [];
        $labels30Days = [];
        $data7Days = [];
        $labels7Days = [];

        $checkDate7 = $endDate->copy()->subDays(6);

        foreach ($period30 as $date) {
            $dateString = $date->format('Y-m-d');
            $count = ($sertifikat30->has($dateString) ? $sertifikat30[$dateString]->count() : 0) + 
                     ($umkm30->has($dateString) ? $umkm30[$dateString]->count() : 0);
            
            $data30Days[] = $count;
            $labels30Days[] = $date->format('d M');

            // Filter for last 7 days including today
            if ($date->gte($checkDate7)) {
                $data7Days[] = $count;
                $labels7Days[] = $date->locale('id')->isoFormat('dddd');
            }
        }

        // 2. Data for Last Month
        $startLastMonth = $endDate->copy()->subMonth()->startOfMonth();
        $endLastMonth = $endDate->copy()->subMonth()->endOfMonth();
        $periodLastMonth = \Carbon\CarbonPeriod::create($startLastMonth, $endLastMonth);

        $sertifikatLastMonth = Sertifikat::whereBetween('created_at', [$startLastMonth, $endLastMonth])->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });
        $umkmLastMonth = Umkm::whereBetween('created_at', [$startLastMonth, $endLastMonth])->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        $dataLastMonth = [];
        $labelsLastMonth = [];

        foreach ($periodLastMonth as $date) {
            $dateString = $date->format('Y-m-d');
            $count = ($sertifikatLastMonth->has($dateString) ? $sertifikatLastMonth[$dateString]->count() : 0) + 
                     ($umkmLastMonth->has($dateString) ? $umkmLastMonth[$dateString]->count() : 0);
            
            $dataLastMonth[] = $count;
            $labelsLastMonth[] = $date->format('d M');
        }


        // 3. Data for Yearly (Current Year)
        $startYear = $endDate->copy()->startOfYear();
        $months = [];
        $dataYear = [];
        
        $sertifikatYear = Sertifikat::where('created_at', '>=', $startYear)
            ->selectRaw('count(*) as count, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('count', 'month');
            
        $umkmYear = Umkm::where('created_at', '>=', $startYear)
            ->selectRaw('count(*) as count, MONTH(created_at) as month')
            ->groupBy('month')
            ->pluck('count', 'month');

        for ($m = 1; $m <= 12; $m++) {
            $monthDate = \Carbon\Carbon::createFromDate(null, $m, 1);
            $months[] = $monthDate->locale('id')->isoFormat('MMMM');
            $count = ($sertifikatYear[$m] ?? 0) + ($umkmYear[$m] ?? 0);
            $dataYear[] = $count;
        }

        $chartData = [
            'seven_days' => ['labels' => $labels7Days, 'data' => $data7Days],
            'thirty_days' => ['labels' => $labels30Days, 'data' => $data30Days],
            'last_month' => ['labels' => $labelsLastMonth, 'data' => $dataLastMonth],
            'year' => ['labels' => $months, 'data' => $dataYear],
        ];

        return view('admin.dashboard', compact('stats', 'activities', 'chartData'));
    }

    public function talent()
    {
        $user = Auth::user();
        $talent = $user->talent;

        if (!$talent) {
            $talent = Talent::create(['user_id' => $user->id, 'nama_lengkap' => $user->name]);
        }

        $stats = [
            'total_lamaran' => Lamaran::where('talent_id', $talent->id)->count(),
            'total_tes' => $user->hasilTes ? $user->hasilTes()->count() : 0,
            'total_sertifikat' => Sertifikat::where('user_id', $user->id)->count(),
            'profile_completion' => $this->calculateProfileCompletion($talent),
            'rata_skor' => $user->hasilTes ? round($user->hasilTes()->avg('skor')) : 0,
        ];

        $recent_lamaran = Lamaran::with(['lowongan.umkm'])
            ->where('talent_id', $talent->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $skills_data = HasilTes::with('kategori')
            ->where('user_id', $user->id)
            ->orderBy('skor', 'desc')
            ->limit(5)
            ->get();

        $recent_sertifikat = Sertifikat::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('talent.dashboard', compact('stats', 'recent_lamaran', 'skills_data', 'recent_sertifikat', 'talent'));
    }

    public function umkm()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) {
            $umkm = Umkm::create([
                'user_id' => $user->id,
                'nama_umkm' => $user->name,
                'email_instansi' => $user->email,
            ]);
        }

        $stats = [
            'total_lowongan' => Lowongan::where('umkm_id', $umkm->id)->where('status', 'aktif')->count(),
            'total_pelamar' => Lamaran::whereHas('lowongan', function ($q) use ($umkm) {
                $q->where('umkm_id', $umkm->id);
            })->count(),
            'total_review' => Lamaran::whereHas('lowongan', function ($q) use ($umkm) {
                $q->where('umkm_id', $umkm->id);
            })->where('status', 'Pending')->count(),
            'total_wawancara' => Lamaran::whereHas('lowongan', function ($q) use ($umkm) {
                $q->where('umkm_id', $umkm->id);
            })->where('status', 'Interview')->count(),
            'total_diterima' => Lamaran::whereHas('lowongan', function ($q) use ($umkm) {
                $q->where('umkm_id', $umkm->id);
            })->where('status', 'Diterima')->count(),
        ];

        $recent_lowongan = Lowongan::withCount('lamaran')
            ->where('umkm_id', $umkm->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('umkm.dashboard', compact('stats', 'umkm', 'recent_lowongan'));
    }

    public function skillTests()
    {
        $categories = KategoriSkill::withCount('soal')->get();
        return view('talent.skill_tests.index', compact('categories'));
    }

    public function takeTest(KategoriSkill $category)
    {
        $questions = $category->soal()
            ->whereIn('status', ['active', 'Aktif'])
            ->where('tipe_soal', 'pilihan_ganda')
            ->inRandomOrder()
            ->take(20)
            ->get();
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada soal tersedia untuk kategori ini atau status soal belum aktif.');
        }
        return view('talent.skill_tests.show', compact('category', 'questions'));
    }

    public function submitTest(Request $request, KategoriSkill $category)
    {
        $answers = $request->input('answers', []);
        $questionIds = array_keys($answers);

        if (empty($questionIds)) {
            return redirect()->back()->with('error', 'Anda harus menjawab setidaknya satu soal.');
        }

        $questions = SoalSkill::whereIn('id', $questionIds)->get();
        $correct = 0;
        $total = $questions->count();

        foreach ($questions as $q) {
            $userAnswer = $answers[$q->id] ?? null;
            if ($userAnswer && strtoupper($userAnswer) == strtoupper($q->jawaban_benar)) {
                $correct++;
            }
        }

        $score = $total > 0 ? ($correct / $total) * 100 : 0;

        HasilTes::create([
            'user_id' => Auth::id(),
            'kategori_id' => $category->id,
            'skor' => round($score, 2),
            'total_soal' => $total,
            'jawaban_benar' => $correct,
        ]);

        return redirect()->route('talent.skill-tests')->with('success', "Tes selesai! Skor Anda: " . round($score, 2));
    }


    public function adminFeature(Request $request)
    {
        return view('admin.feature', ['feature' => $request->route()->getName()]);
    }

    public function talentFeature(Request $request)
    {
        return view('talent.feature', ['feature' => $request->route()->getName()]);
    }

    public function umkmFeature(Request $request)
    {
        return view('umkm.feature', ['feature' => $request->route()->getName()]);
    }

    public function notifications()
    {
        $notifications = \App\Models\Notifikasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $unreadCount = \App\Models\Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(\App\Models\Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id == Auth::id()) {
            $notifikasi->update(['is_read' => true]);
        }

        $link = $this->getMappedLink($notifikasi->link);

        return $link ? redirect($link) : redirect()->back();
    }

    public function markAllRead()
    {
        \App\Models\Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    private function getMappedLink($legacyLink)
    {
        if (!$legacyLink || $legacyLink == '#') {
            return null;
        }

        // Mapping array for legacy native paths to Laravel routes
        $mappings = [
            'dashboard_umkm/instansi/code.php' => 'umkm.dashboard',
            'dashboard_umkm/lowongan/code.php' => 'umkm.jobs',
            'dashboard_umkm/pesan/code.php' => 'umkm.messages',
            'dashboard_umkm/notifikasi/code.php' => 'umkm.notifications',
            'dashboard_talent/profil/code.php' => 'talent.profile',
            'dashboard_talent/lowongan/code.php' => 'talent.jobs',
            'dashboard_talent/pesan/code.php' => 'talent.messages',
            'dashboard_talent/notifikasi/code.php' => 'talent.notifications',
            'dashboard_talent/riwayat_lamaran/code.php' => 'talent.applications',
            'dashboard_talent/sertifikat/code.php' => 'talent.certificates',
            'dashboard_admin/verifikasi_akun_umkm/code.php' => 'admin.verification.umkm',
            'dashboard_admin/verifikasi_sertifikat_admin/code.php' => 'admin.verification.certificates',
            'dashboard_admin/manajemen_user/code.php' => 'admin.users',
            'dashboard_admin/kelola_tes_skill/code.php' => 'admin.skill-tests',
        ];

        // Clean link (remove ../ and leading /)
        $cleanPath = str_replace('../', '', ltrim($legacyLink, '/'));

        foreach ($mappings as $legacyPath => $routeName) {
            if (str_contains($cleanPath, $legacyPath)) {
                try {
                    return route($routeName);
                } catch (\Exception $e) {
                    return null;
                }
            }
        }

        // If it's already a valid Laravel internal path or external URL
        if (str_starts_with($legacyLink, 'http') || !str_contains($legacyLink, '.php')) {
            return $legacyLink;
        }

        return null;
    }

    private function calculateProfileCompletion($talent)
    {
        $fields = ['nama_lengkap', 'deskripsi', 'tanggal_lahir', 'jenis_kelamin', 'status_pernikahan', 'alamat', 'telepon', 'hobi', 'pekerjaan_saat_ini', 'pengalaman_kerja', 'pendidikan_terakhir', 'skill', 'linkedin', 'portfolio', 'foto'];
        $filledCount = 0;
        foreach ($fields as $f) {
            if (!empty($talent->$f))
                $filledCount++;
        }
        return round(($filledCount / count($fields)) * 100);
    }
}
