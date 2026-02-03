<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Opsional: Hapus data lama agar tidak duplicate entry jika seeder dijalankan ulang
        // DB::table('users')->truncate();

        DB::table("users")->insert([
            [
                "id" => 1,
                "name" => "Sultan Abdul ",
                "email" => "sultan@abc.com",
                "email_verified_at" => null,
                "password" => '$2y$12$y.MrxX7OvkVg8t/a2bypLeqV5dDIPQN7MBfWcieXTCmRUMvvd7xP2', // Hash bawaan dari SQL
                "remember_token" => null,
                "created_at" => "2026-02-01 08:34:53",
                "updated_at" => "2026-02-01 08:34:53",
                "avatar" => "avatar/lJxNnz91s71zPWrYf4SrHhKJIVUfOG0Sh8l5Pe3e.jpg",
                "username" => "sultan",
                "role" => "admin",
            ],
            [
                "id" => 2,
                "name" => "Client milku760",
                "email" => "milku@gmail.com",
                "email_verified_at" => null,
                "password" => '$2y$12$P8kfXME7Vw1jMEZZW0c.cOMz22JSIM7Z7j484sYWmZFNLZocswYra',
                "remember_token" => null,
                "created_at" => "2026-02-01 08:35:48",
                "updated_at" => "2026-02-01 08:39:22",
                "avatar" => null,
                "username" => "milku760",
                "role" => "client",
            ],
            [
                "id" => 3,
                "name" => "tim",
                "email" => "tim@gmail.com",
                "email_verified_at" => null,
                "password" => '$2y$12$vRZCKuda4QhM4kS/ENQ3iualV05cRmrCIR6IocDrDmY03nqCmrHAG',
                "remember_token" => null,
                "created_at" => "2026-02-01 08:36:19",
                "updated_at" => "2026-02-01 08:36:19",
                "avatar" => null,
                "username" => "timDoc",
                "role" => "tim_dokumentasi",
            ],
            [
                "id" => 4,
                "name" => "Client korek682",
                "email" => "korek@gmail.com",
                "email_verified_at" => null,
                "password" => '$2y$12$dOBh1oaL15VYYV0fU6eE3.j/utOMOkS9f8p5LjT1G2FmJhe1LdHC6',
                "remember_token" => null,
                "created_at" => "2026-02-01 08:40:49",
                "updated_at" => "2026-02-01 08:40:49",
                "avatar" => null,
                "username" => "korek682",
                "role" => "client",
            ],
        ]);
    }
}
