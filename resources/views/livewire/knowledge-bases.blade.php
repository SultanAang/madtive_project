<div class="bg-gray-50 min-h-screen">
    
    {{-- Tambahkan Style Animasi Custom --}}
    <style>
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-down {
            animation: fadeDown 0.8s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0; /* Mulai invisible */
        }
    </style>

    {{-- Mobile Header --}}
    <div class="lg:hidden p-4 border-b flex items-center sticky top-0 bg-white/90 backdrop-blur-md z-20 shadow-sm transition-all">
        <label for="main-drawer" class="btn btn-square btn-ghost btn-sm mr-2">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <span class="font-bold">Knowledge Base</span>
    </div>

    <div class="max-w-6xl mx-auto py-12 px-6">
        
        {{-- HEADER & SEARCH (Animasi Masuk dari Atas) --}}
        <div class="text-center max-w-2xl mx-auto mb-16 animate-fade-down">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Dokumentasi & Tutorial</h1>
            <p class="text-lg text-gray-500 mb-8">Pelajari cara menggunakan sistem dengan panduan lengkap kami.</p>

            {{-- Search Bar --}}
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <x-icon name="o-magnifying-glass" class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" />
                </div>
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 hover:shadow-md"
                    placeholder="Cari tutorial..."
                >
                {{-- Spinner Loading Search --}}
                <div wire:loading wire:target="search" class="absolute inset-y-0 right-4 flex items-center">
                    <x-icon name="o-arrow-path" class="w-5 h-5 text-indigo-500 animate-spin" />
                </div>
            </div>

            {{-- Filter Kategori (Animasi Fade In) --}}
            @if($categories->count() >= 0)
                <div class="flex flex-wrap justify-center gap-2 mt-6 animate-fade-in-up delay-200" style="animation-delay: 200ms; animation-fill-mode: forwards;">
                    <button 
                        wire:click="$set('category', '')"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-300 transform active:scale-95 
                        {{ $category == '' 
                            ? 'bg-indigo-600 text-white shadow-lg ring-2 ring-offset-2 ring-indigo-500 scale-105' 
                            : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 hover:border-indigo-200' 
                        }}"
                    >
                        Semua
                    </button>
                    @foreach($categories as $cat)
                        <button 
                            wire:click="$set('category', '{{ $cat }}')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-300 transform active:scale-95
                            {{ $category == $cat 
                                ? 'bg-indigo-600 text-white shadow-lg ring-2 ring-offset-2 ring-indigo-500 scale-105' 
                                : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 hover:border-indigo-200' 
                            }}"
                        >
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- GRID ARTIKEL --}}
        {{-- wire:loading.class.remove="opacity-100" wire:loading.class="opacity-50 blur-sm" --}}
        {{-- Tambahkan transisi opacity saat loading pencarian --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 transition-all duration-300" wire:loading.class="opacity-50 blur-sm">
            @forelse($articles as $index => $article)
                <a 
                    href="/knowledge/{{ $article->slug }}" 
                    class="group flex flex-col bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden h-full animate-fade-in-up"
                    style="animation-delay: {{ $index * 100 }}ms; animation-fill-mode: forwards;" {{-- Staggered Animation --}}
                >
                    
                    {{-- Ikon/Thumbnail Abstrak --}}
                    <div class="h-32 bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center group-hover:from-indigo-100 group-hover:to-blue-100 transition-colors duration-500 relative overflow-hidden">
                        {{-- Efek Lingkaran Dekoratif --}}
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white opacity-20 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <x-icon name="o-document-text" class="w-12 h-12 text-indigo-300 group-hover:text-indigo-600 group-hover:scale-110 transition-all duration-300" />
                    </div>

                    <div class="p-6 flex-1 flex flex-col relative">
                        {{-- Kategori Badge --}}
                        @if($article->category)
                            <div class="mb-3">
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-gray-100 text-gray-600 uppercase tracking-wide group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    {{ $article->category }}
                                </span>
                            </div>
                        @endif

                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors leading-snug">
                            {{ $article->title }}
                        </h3>

                        {{-- Cuplikan Isi --}}
                        <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-1 group-hover:text-gray-600 transition-colors">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <div class="flex items-center text-indigo-600 font-semibold text-sm mt-auto group/btn">
                            <span class="relative">
                                Baca Panduan
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover/btn:w-full"></span>
                            </span>
                            <x-icon name="o-arrow-right" class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20 animate-fade-in-up">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-4 animate-bounce" style="animation-duration: 3s;">
                        <x-icon name="o-book-open" class="w-12 h-12 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada artikel</h3>
                    <p class="text-gray-500">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination (Fade In Terakhir) --}}
        <div class="mt-12 animate-fade-in-up delay-300" style="animation-delay: 300ms; animation-fill-mode: forwards;">
            {{ $articles->links() }} 
        </div>

    </div>
</div>