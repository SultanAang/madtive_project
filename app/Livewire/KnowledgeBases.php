<?php

namespace App\Livewire;

use App\Models\KnowledgeBase;
use Livewire\Component;
use Livewire\WithPagination;

class KnowledgeBases extends Component
{
    use WithPagination; // Agar bisa ada halaman 1, 2, dst

    public $search = '';
    public $category = '';

    // Reset halaman ke 1 setiap kali mengetik pencarian
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $articles = KnowledgeBase::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->latest() // Artikel terbaru di atas
            ->paginate(9); // Tampilkan 9 artikel per halaman

        // Ambil daftar kategori unik untuk filter
        $categories = KnowledgeBase::select('category')->distinct()->pluck('category');

        return view('livewire.knowledge-bases', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}