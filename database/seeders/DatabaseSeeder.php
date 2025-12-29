<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Umkm;
use App\Models\Talent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active', 
        ]);

        Admin::create([
            'user_id' => $adminUser->id,
            'nama_admin' => 'Administrator',
        ]);

        // 2. UMKM User
        $umkmUser = User::create([
            'name' => 'UMKM User',
            'email' => 'umkm@example.com',
            'password' => Hash::make('password'),
            'role' => 'umkm',
            'status' => 'active',
        ]);

        Umkm::create([
            'user_id' => $umkmUser->id,
            'nama_perusahaan' => 'PT UMKM Maju',
            'nama_umkm' => 'UMKM Maju',
            'deskripsi' => 'UMKM yang bergerak di bidang teknologi',
            'status_verifikasi' => 'verified',
        ]);

        // 3. Talent User
        $talentUser = User::create([
            'name' => 'Talent User',
            'email' => 'talent@example.com',
            'password' => Hash::make('password'),
            'role' => 'talent',
            'status' => 'active',
        ]);

        Talent::create([
            'user_id' => $talentUser->id,
            'nama_lengkap' => 'Talent Profesional',
            'deskripsi' => 'Seorang talent berbakat',
            'jenis_kelamin' => 'Laki-laki',
            'status_pernikahan' => 'Belum Menikah',
        ]);

        $this->command->info('Users and related data have been seeded!');
    }
}
