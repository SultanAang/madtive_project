<div class="bg-gray-50 min-h-screen">
    
    {{-- Mobile Header --}}
    <div class="lg:hidden p-4 border-b flex items-center sticky top-0 bg-white z-20">
        <label for="main-drawer" class="btn btn-square btn-ghost btn-sm mr-2">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <span class="font-bold">F.A.Q</span>
    </div>

    <div class="max-w-3xl mx-auto py-12 px-6">
        
        {{-- Header & Search --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Pusat Bantuan</h1>
            <p class="text-gray-500 mb-8">Cari jawaban untuk pertanyaan yang sering diajukan.</p>

            {{-- Kolom Pencarian --}}
            <div class="relative max-w-lg mx-auto">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="o-magnifying-glass" class="w-5 h-5 text-gray-400" />
                </div>
                <input 
                    wire:model.live="search" 
                    type="text" 
                    class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" 
                    placeholder="Cari pertanyaan... (misal: pembayaran)"
                >
            </div>
        </div>

        {{-- List FAQ --}}
        <div class="space-y-4">
            @forelse($faqs as $faq)
                {{-- Item Accordion --}}
                <div x-data="{ open: false }" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                    
                    {{-- Tombol Pertanyaan --}}
                    <button 
                        @click="open = !open" 
                        class="w-full text-left px-6 py-4 flex justify-between items-center focus:outline-none bg-white"
                    >
                        <div>
                            {{-- Badge Kategori (Jika ada) --}}
                            @if($faq->category)
                                <span class="text-xs font-bold uppercase tracking-wider text-indigo-500 mb-1 block">
                                    {{ $faq->category }}
                                </span>
                            @endif
                            <h3 class="text-lg font-semibold text-gray-800">{{ $faq->question }}</h3>
                        </div>
                        
                        {{-- Icon Panah (Berputar saat dibuka) --}}
                        <span :class="{'rotate-180': open}" class="transform transition-transform duration-200 text-gray-400">
                            <x-icon name="o-chevron-down" class="w-5 h-5" />
                        </span>
                    </button>

                    {{-- Isi Jawaban (Muncul saat open = true) --}}
                    <div 
                        x-show="open" 
                        x-collapse 
                        class="px-6 pb-6 pt-0 text-gray-600 prose prose-indigo max-w-none border-t border-gray-50 bg-gray-50/50"
                    >
                        <div class="pt-4">
                            {!! $faq->answer !!}
                        </div>
                    </div>
                </div>
            @empty
                {{-- State Kosong --}}
                <div class="text-center py-12">
                    <x-icon name="o-question-mark-circle" class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                    <h3 class="text-lg font-medium text-gray-900">Tidak ditemukan</h3>
                    <p class="text-gray-500">Coba kata kunci lain.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer Kontak --}}
        <div class="mt-12 text-center">
            <p class="text-gray-500">
                Masih butuh bantuan? 
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Hubungi Support</a>
            </p>
        </div>

    </div>
</div>