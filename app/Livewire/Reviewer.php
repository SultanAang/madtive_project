<?php

namespace App\Livewire; // Namespace disesuaikan agar file ada di app/Livewire/Reviewer.php

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Faq;
use App\Models\Roadmap;
use App\Models\Release;
use App\Models\KnowledgeBase;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;

class Reviewer extends Component {
    // [FIX 1] Typo: 'releases' harus 'release' agar cocok dengan key di Blade
    public $activeTab = "release";

    public $showRejectModal = false;
    public $rejectId;
    public $rejectType;
    public $rejectionNote = "";

    public $showDetailModal = false;
    public $selectedItem = null;

    #[Title("Reviewer Dashboard")]
    #[Layout("reviewer")]
    public function render() {
        // 1. Logic Ambil Data
        $items = match ($this->activeTab) {
            "release" => Release::where("is_approve", "draft")->latest()->get(),
            "roadmap" => Roadmap::where("is_approve", "draft")->orderBy("eta")->get(),
            "faq" => Faq::where("is_approve", "draft")->latest()->get(),
            "knowledge" => KnowledgeBase::where("is_approve", "draft")->latest()->get(),
            default => collect(),
        };

        // 2. Logic Hitung Badge
        // [FIX 2] Typo: 'is_appprove' (kebanyakan p) diubah jadi 'is_approve'
        $counts = [
            "release" => Release::where("is_approve", "draft")->count(),
            "roadmap" => Roadmap::where("is_approve", "draft")->count(),
            "faq" => Faq::where("is_approve", "draft")->count(),
            "knowledge" => KnowledgeBase::where("is_approve", "draft")->count(),
        ];

        // 3. Return View
        // Karena $activeTab adalah public property, dia OTOMATIS dikirim ke view.
        // Tapi kita kirim explicit data items dan counts.
        // dd("", $items, $counts);
        return view("livewire.reviewer_base", [
            "items" => $items,
            "counts" => $counts,
        ]); // Pastikan layout wrapper ini ada
    }

    public function setTab($tab) {
        $this->activeTab = $tab;
        $this->selectedItem = null;
    }
    public function showDetail($type, $id) {
        $this->selectedItem = $this->getModel($type, $id);
        $this->showDetailModal = true;
    }

    public function approve($type, $id) {
        $model = $this->getModel($type, $id);
        if ($model) {
            $model->update(["is_approve" => "published"]); // Sesuaikan nama kolom di DB
            $this->showDetailModal = false;
            session()->flash("success", "Data berhasil disetujui!");
        }
    }

    public function confirmReject($type, $id) {
        $this->rejectType = $type;
        $this->rejectId = $id;
        $this->rejectionNote = "";

        // Tutup modal detail agar tidak tumpang tindih, lalu buka modal reject
        $this->showDetailModal = false;
        $this->showRejectModal = true;
    }

    public function submitReject() {
        $this->validate([
            "rejectionNote" => "required|min:5|max:500",
        ]);

        $model = $this->getModel($this->rejectType, $this->rejectId);
        if ($model) {
            $model->update([
                "is_approve" => "rejected", // Sesuaikan nama kolom di DB
                "rejection_note" => $this->rejectionNote,
            ]);
            $this->showRejectModal = false;
            session()->flash("success", "Data ditolak.");
        }
    }

    private function getModel($type, $id): ?Model {
        return match ($type) {
            "release" => Release::find($id),
            "roadmap" => Roadmap::find($id),
            "faq" => Faq::find($id),
            "knowledge" => KnowledgeBase::find($id),
            default => null,
        };
    }
}
