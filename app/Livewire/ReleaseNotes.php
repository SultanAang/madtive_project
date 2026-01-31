<?php

namespace App\Livewire;

use App\Models\Release;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class ReleaseNotes extends Component {
    
    public $feedback = "";
    
    // 1. Variable untuk menyimpan ID versi yang dipilih di dropdown
    public $selectedVersionId;

    #[Layout("release_notes")] 
    #[Title("Release Notes")]
    public function mount() {
        // 2. Saat halaman dibuka, otomatis pilih versi paling baru (jika ada)
        $latest = Release::where('is_visible', true)->latest('published_at')->first();
        
        if ($latest) {
            $this->selectedVersionId = $latest->id;
        }
    }

    public function render() {
        // 3. Ambil daftar versi UNTUK DROPDOWN saja (ringan)
        $versionList = Release::where('is_visible', true)
                        ->orderBy('published_at', 'desc')
                        ->get(['id', 'version', 'published_at']); // Ambil kolom penting aja

        // 4. Ambil FULL DATA untuk versi yang SEDANG DIPILIH
        $selectedRelease = Release::find($this->selectedVersionId);

        return view("livewire.release_notes", [
            'versionList' => $versionList,
            'selectedRelease' => $selectedRelease
        ]);
    }

    public function sendFeedback() {
        if (!$this->feedback) return;
        session()->flash("success", "Terima kasih! Masukan Anda telah kami terima.");
        $this->feedback = ""; 
    }
}