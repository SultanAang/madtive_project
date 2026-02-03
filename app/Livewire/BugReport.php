<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk upload file
use Livewire\Attributes\Validate; // Fitur Validasi Modern
use App\Models\BugReport as BugModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
class BugReport extends Component {
    use WithFileUploads;

    // --- Properties dengan Validasi Langsung ---

    #[Validate("required|min:5|max:100", as: "Judul Masalah")]
    public $title = "";

    #[Validate("required|min:10", as: "Deskripsi")]
    public $description = "";

    #[Validate("required|in:low,medium,high,critical")]
    public $priority = "medium"; // Max 2MB

    #[Validate("nullable|image|max:2048", as: "Screenshot")]
    public $screenshot; // Validasi wajib pilih

    public $project_id;
    #[Url(keep: true)]
    public $selectedProject;
    public $allProjects;

    // --- Action Methods ---
    // public function mount($currentProjectId) {
    //     $this->project_id = $currentProjectId;
    // }
    
    
    public function save() {
        // 1. Jalankan Validasi (otomatis baca attributes di atas)
        $this->validate([
            'title' => 'required', 
            'description' => 'required',
            'project_id' => 'required|exists:projects,id',
        ]);

        // 2. Handle Upload Gambar (Jika ada)
        $path = null;
        if ($this->screenshot) {
            // Simpan ke storage/app/public/bugs
            $path = $this->screenshot->store("bugs", "public");
        }

        // 3. Simpan ke Database
        BugModel::create([
            "user_id" => Auth::id(),
            'project_id' => $this->project_id,
            "title" => $this->title,
            "description" => $this->description,
            "priority" => $this->priority,
            "screenshot_path" => $path,
            "status" => "pending",
        ]);

        // 4. Reset Form & Beri Notifikasi
        $this->reset(["title", "description", "priority", "screenshot"]);

        // Gunakan session flash atau dispatch event notifikasi
        session()->flash(
            "success",
            "Laporan bug berhasil dikirim! Terima kasih atas masukan Anda.",
        );
    }

    public function render() {
        $user = Auth::user();

        // Ambil semua project milik Client ini
        // Pastikan relasi 'client' dan 'projects' sudah ada di Model User
        $this->allProjects = $user->client?->projects ?? collect();

        // --- LOGIC ANDA DISINI ---
        
        // 1. Cek apakah ada request ID dari URL
        if ($this->project_id) {
            // Cari project tersebut di list milik user (Security Check)
            $this->selectedProject = $this->allProjects->where('id', $this->project_id)->first();
        }

        // 2. Fallback: Jika ID di URL ngawur atau kosong, pilih project pertama
        if (! $this->selectedProject) {
            $this->selectedProject = $this->allProjects->first();
            
            // Sync balik ID-nya agar properti tidak null
            if ($this->selectedProject) {
                $this->project_id = $this->selectedProject->id;
            }
        }

        // 3. (Opsional) Jika user sama sekali tidak punya project
        if (! $this->selectedProject) {
            // Bisa redirect atau set error state
            // return redirect()->route('home'); 
        }
        return view("livewire.bug-report");
    }
}
