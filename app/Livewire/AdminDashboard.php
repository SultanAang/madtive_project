<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\Layout; // <--- 1. Pastikan ini ada

class AdminDashboard extends Component {
    // --- STATE UNTUK MODAL ---
    public $isModalOpen = false;
    public $modalTitle = "";
    public $selectedProjects = []; // Menampung list data saat kartu diklik

    // --- FUNGSI KLIK KARTU ---
    public function openList($type) {
        $this->isModalOpen = true;
        $now = now();

        // Logika pengambilan data berdasarkan tipe kartu yang diklik
        switch ($type) {
            case "ongoing":
                $this->modalTitle = "Daftar Project Berjalan (Ongoing)";
                $this->selectedProjects = Project::where("status", "ongoing")
                    ->with("client")
                    ->get();
                break;

            case "pending":
                $this->modalTitle = "Daftar Project Belum Dikerjakan (Pending)";
                $this->selectedProjects = Project::where("status", "pending")
                    ->with("client")
                    ->get();
                break;

            case "overdue":
                $this->modalTitle = "WARNING: Project Lewat Deadline!";
                $this->selectedProjects = Project::where("deadline", "<", $now)
                    ->where("status", "!=", "finished")
                    ->with("client")
                    ->get();
                break;

            case "clients":
                // Khusus client beda tabel, tapi kita simpan di variabel yang sama biar praktis
                // Atau kamu bisa buat variabel terpisah jika mau structure datanya beda
                $this->modalTitle = "Daftar Semua Client";
                $this->selectedProjects = Client::latest()->get();
                break;
        }
    }

    public function closeModal() {
        $this->isModalOpen = false;
        $this->selectedProjects = [];
    }
    #[Layout("admin")]
    public function render() {
        // 1. Ambil Tanggal Hari Ini
        $now = now();

        return view("adminDashboard", [
            // --- STATISTIK KARTU ---
            "total_active" => Project::where("status", "ongoing")->count(),
            "total_clients" => Client::count(),
            "total_pending" => Project::where("status", "pending")->count(),
            // Overdue: Deadline sudah lewat TAPI status belum 'finished'
            "total_overdue" => Project::where("deadline", "<", $now)
                ->where("status", "!=", "finished")
                ->count(),

            // --- PROGRESS PROJECT TERBARU (Ambil 5) ---
            "recent_projects" => Project::latest()->take(5)->get(),

            // --- DEADLINE ALERT (H-7) ---
            // Ambil project yang deadlinenya antara HARI INI sampai 7 HARI KEDEPAN
            // Dan statusnya belum selesai
            "urgent_projects" => Project::whereBetween("deadline", [$now, $now->copy()->addDays(7)])
                ->where("status", "!=", "finished")
                ->orderBy("deadline", "asc") // Urutkan yang paling mepet
                ->get(),
        ]);
    }
}
