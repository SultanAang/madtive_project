<?php

namespace App\Livewire;

use App\Models\Faq;
use Livewire\Component;

class Faqs extends Component
{
    public $search = '';

    public function render()
    {
        $faqs = Faq::where('is_visible', true)
            ->where(function($query) {
                $query->where('question', 'like', '%' . $this->search . '%')
                      ->orWhere('answer', 'like', '%' . $this->search . '%');
            })
            // Urutkan berdasarkan kategori, lalu ID (opsional)
            ->orderBy('category') 
            ->get();

        return view('livewire.faqs', [
            'faqs' => $faqs
        ]);
    }
}