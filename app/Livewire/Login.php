<?php

namespace App\Livewire;

// namespace View\Livewire;
use Views\Livewire;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

use Filament\Facades\Filament;
class Login extends Component {
    #[Validate("required|min:4")]
    public $username = "";
    #[Validate("required|min:3")]
    public $password = "";

    public function login() {
        // Menjalankan validasi berdasarkan atribut #[Rule]
        $validated = $this->validate();
        if (Auth::attempt(["username" => $this->username, "password" => $this->password])) {
            session()->regenerate();

            $role = Auth::user()->role;
            $user = auth::user();

            Filament::auth()->login($user);
            return match ($role) {
                "admin" => redirect()->route("admin.dashboard"),
                "client" => redirect()->route("client.dashboard"),

                "tim_dokumentasi" => (function() {
                // Cek dulu apakah project kosong?
                    if (\App\Models\Project::count() === 0) {
                        return redirect()->route("no.project"); // Lempar ke Ruang Tunggu
                    }

                // Jika ada project, lempar ke Filament Panel
                // Pastikan ID panel benar ('mencoba' atau 'admin' atau yg lain)
                return redirect()->to(Filament::getPanel("mencoba")->getUrl());
                })(),
                "reviewer_internal" => redirect()->route("reviewer.dashboard"),

                default => redirect("/"), // Jaga-jaga jika role tidak dikenali
            };

            session()->flash("success", "Anda Sudah Login");
            // return redirect()->intended('/users');
        }

        // Jika gagal, tambahkan error manual
        // $this->addError('username', 'Email atau password yang Anda masukkan salah.');
        $this->reset();
    }
    public function render() {
        return view("livewire.login", [
            "title" => "Welcome Page",
            "users" => Login::all(),
        ]);
    }
}
