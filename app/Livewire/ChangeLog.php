<?php

namespace App\Livewire;

use App\Models\Release;
use Livewire\Component;

class ChangeLog extends Component { // Pastikan nama class sesuai nama file
    // Fungsi ini akan dijalankan saat halaman dibuka
    public function render() {
        // 1. Ambil data Release disini (Bukan di Controller lama)
        $releases = Release::where("is_visible", true)->orderBy("published_at", "desc")->get();

        // 2. Kirim data ke view livewire, DAN tentukan Wrapper-nya
        return view("livewire.changelog", [
            // Sesuaikan nama file view di folder livewire
            "releases" => $releases,
        ]); // <--- INI KUNCINYA! Kita panggil wrapper 'changelog' disini.
    }
}
