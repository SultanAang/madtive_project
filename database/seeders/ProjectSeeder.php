<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('password'); // Password login: password

        // KITA GUNAKAN STATUS YANG SESUAI DATABASE: 'pending', 'ongoing', 'finished'
        $scenarios = [
            [
                'client_name'  => 'Pemkab Cianjur',
                'client_email' => 'admin@cianjur.go.id',
                'project_name' => 'Website Profil Desa',
                'status'       => 'finished', // <--- SUDAH DISESUAIKAN (Bukan 'done')
                'progress'     => 100,
                'desc'         => 'Sistem informasi profil desa terintegrasi kependudukan.',
            ],
            [
                'client_name'  => 'Rektorat UNAS',
                'client_email' => 'rektor@unas.ac.id',
                'project_name' => 'SIAKAD Kampus v2',
                'status'       => 'ongoing', // Sesuai database
                'progress'     => 65,
                'desc'         => 'Sistem Akademik Mahasiswa dan Dosen (Mobile App).',
            ],
            [
                'client_name'  => 'Owner Batik Alus',
                'client_email' => 'boss@batikalus.com',
                'project_name' => 'E-Commerce Batik',
                'status'       => 'pending', // Sesuai database
                'progress'     => 0,
                'desc'         => 'Marketplace batik tulis dengan payment gateway Midtrans.',
            ],
            [
                'client_name'  => 'Manager Kopi Senja',
                'client_email' => 'manager@kopisenja.com',
                'project_name' => 'Aplikasi Kasir (POS)',
                'status'       => 'ongoing', // Sesuai database
                'progress'     => 45,
                'desc'         => 'Aplikasi tablet Android untuk kasir coffee shop.',
            ],
            [
                'client_name'  => 'Xiaomi Indonesia',
                'client_email' => 'client@xiaomi.co.id',
                'project_name' => 'Xiaomi Community App',
                'status'       => 'pending', // Sesuai database
                'progress'     => 10,
                'desc'         => 'Forum komunitas pengguna Xiaomi berbasis web.',
            ],
        ];

        foreach ($scenarios as $data) {
            
            // 1. Cek atau Buat User (Client)
            $user = DB::table('users')->where('email', $data['client_email'])->first();
            
            if (!$user) {
                $clientId = DB::table('users')->insertGetId([
                    'name'       => $data['client_name'],
                    'email'      => $data['client_email'],
                    'password'   => $defaultPassword,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $clientId = $user->id;
            }

            // 2. Buat Project
            DB::table('projects')->insert([
                'client_id'   => $clientId,
                'name'        => $data['project_name'],
                'slug'        => Str::slug($data['project_name']),
                'description' => $data['desc'],
                'status'      => $data['status'], // <--- Aman, karena sudah pakai kata yang benar
                'progress'    => $data['progress'],
                'deadline'    => now()->addDays(rand(30, 100)),
                'logo'        => 'https://ui-avatars.com/api/?name=' . urlencode($data['project_name']) . '&background=random&color=fff&size=512',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}