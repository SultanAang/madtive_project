<div class="bg-gray-50 min-h-screen">
    
    {{-- Mobile Header --}}
    <div class="lg:hidden p-4 border-b flex items-center sticky top-0 bg-white z-20">
        <label for="main-drawer" class="btn btn-square btn-ghost btn-sm mr-2">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <span class="font-bold">Knowledge Base</span>
    </div>

    <div class="max-w-6xl mx-auto py-12 px-6">
        
        {{-- HEADER & SEARCH --}}
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Dokumentasi & Tutorial</h1>
            <p class="text-lg text-gray-500 mb-8">Pelajari cara menggunakan sistem dengan panduan lengkap kami.</p>

            {{-- Search Bar --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <x-icon name="o-magnifying-glass" class="w-5 h-5 text-gray-400" />
                </div>
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition"
                    placeholder="Cari tutorial..."
                >
            </div>

            {{-- Filter Kategori (Opsional: Muncul jika ada kategori) --}}
            @if($categories->count() > 0)
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    <button 
                        wire:click="$set('category', '')"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $category == '' ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                    >
                        Semua
                    </button>
                    @foreach($categories as $cat)
                        <button 
                            wire:click="$set('category', '{{ $cat }}')"
                            class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $category == $cat ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                        >
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- GRID ARTIKEL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles as $article)
                <a href="/knowledge/{{ $article->slug }}" class="group flex flex-col bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 overflow-hidden h-full">
                    
                    {{-- Ikon/Thumbnail Abstrak --}}
                    <div class="h-32 bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center group-hover:from-indigo-100 group-hover:to-blue-100 transition">
                        <x-icon name="o-document-text" class="w-12 h-12 text-indigo-300 group-hover:text-indigo-500 transition" />
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        {{-- Kategori Badge --}}
                        @if($article->category)
                            <div class="mb-3">
                                <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-gray-100 text-gray-600 uppercase tracking-wide">
                                    {{ $article->category }}
                                </span>
                            </div>
                        @endif

                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition leading-snug">
                            {{ $article->title }}
                        </h3>

                        {{-- Cuplikan Isi (Strip HTML tags agar rapi) --}}
                        <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-1">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <div class="flex items-center text-indigo-600 font-semibold text-sm mt-auto">
                            Baca Panduan
                            <x-icon name="o-arrow-right" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" />
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <x-icon name="o-book-open" class="w-16 h-16 text-gray-200 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900">Belum ada artikel</h3>
                    <p class="text-gray-500">Coba cari dengan kata kunci lain.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $articles->links() }} 
        </div>

    </div>
</div>