<?php

namespace App\Livewire;

use App\Models\Roadmap;
use Livewire\Component;

class Roadmaps extends Component {
    public $filter = "all"; // Default: Tampilkan semua

    // Pilihan Tab Status
    public $tabs = [
        "all" => "Semua",
        "in_progress" => "Sedang Dikerjakan",
        "planned" => "Direncanakan",
        "done" => "Selesai",
    ];

    public function setFilter($status) {
        $this->filter = $status;
    }

    public function render() {
        $roadmaps = Roadmap::query()
            ->when($this->filter !== "all", function ($query) {
                $query->where("status", $this->filter);
            })
            // [FIX] Mengganti FIELD() dengan CASE WHEN agar kompatibel dengan SQLite
            ->orderByRaw(
                "CASE status 
            WHEN 'in_progress' THEN 1 
            WHEN 'planned' THEN 2 
            WHEN 'done' THEN 3 
            ELSE 4 
        END",
            )
            ->orderBy("eta", "asc")
            ->get();

        return view("livewire.roadmap", [
            "roadmaps" => $roadmaps,
        ]);
    }
}
