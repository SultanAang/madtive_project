<div class="bg-gray-50 min-h-screen">
    
    {{-- Mobile Header --}}
    <div class="lg:hidden p-4 border-b flex items-center sticky top-0 bg-white z-20">
        <label for="main-drawer" class="btn btn-square btn-ghost btn-sm mr-2">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <span class="font-bold">Roadmap</span>
    </div>

    <div class="max-w-4xl mx-auto py-12 px-6">
        
        {{-- HEADER --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Peta Jalan Produk</h1>
            <p class="text-gray-500 text-lg">Lihat apa yang sedang kami kerjakan dan apa yang akan datang.</p>
        </div>

        {{-- TABS FILTER --}}
        <div class="flex flex-wrap justify-center gap-2 mb-10">
            @foreach($tabs as $key => $label)
                <button 
                    wire:click="setFilter('{{ $key }}')"
                    class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-200 
                    {{ $filter === $key 
                        ? 'bg-indigo-600 text-white shadow-lg ring-2 ring-offset-2 ring-indigo-500' 
                        : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' 
                    }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- LIST ROADMAP --}}
        <div class="space-y-6 relative">
            
            {{-- Garis Vertikal (Timeline effect) --}}
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 hidden md:block"></div>

            @forelse($roadmaps as $item)
                <div wire:key="item-{{ $item->id }}" class="relative pl-0 md:pl-12 group">
                    
                    {{-- Dot Timeline --}}
                    <div class="absolute left-0 top-6 w-8 h-8 rounded-full border-4 border-white shadow-sm flex items-center justify-center z-10 hidden md:flex
                        {{ $item->status == 'done' ? 'bg-green-500' : ($item->status == 'in_progress' ? 'bg-yellow-500' : 'bg-gray-400') }}">
                        @if($item->status == 'done')
                            <x-icon name="o-check" class="w-4 h-4 text-white" />
                        @elseif($item->status == 'in_progress')
                            <x-icon name="o-arrow-path" class="w-4 h-4 text-white animate-spin-slow" />
                        @else
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        @endif
                    </div>

                    {{-- Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            
                            {{-- Konten --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    {{-- Badge Status Mobile (Only) --}}
                                    <span class="md:hidden px-2 py-0.5 rounded text-xs font-bold uppercase
                                        {{ $item->status == 'done' ? 'bg-green-100 text-green-700' : ($item->status == 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                                        {{ $tabs[$item->status] ?? $item->status }}
                                    </span>
                                    
                                    <h3 class="text-xl font-bold text-gray-900">{{ $item->title }}</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed">{{ $item->description }}</p>
                            </div>

                            {{-- Tanggal ETA --}}
                            <div class="text-right shrink-0">
                                @if($item->eta)
                                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Estimasi</span>
                                    <span class="text-sm font-semibold text-gray-800 bg-gray-50 px-3 py-1 rounded-lg inline-block mt-1">
                                        {{ \Carbon\Carbon::parse($item->eta)->format('M Y') }}
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-gray-300 uppercase">TBA</span>
                                @endif
                            </div>

                        </div>
                        
                        {{-- Badge Status Desktop (Bawah Card) --}}
                        <div class="mt-4 pt-4 border-t border-gray-50 md:flex items-center hidden">
                             <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide flex items-center gap-2
                                {{ $item->status == 'done' ? 'bg-green-50 text-green-700' : ($item->status == 'in_progress' ? 'bg-yellow-50 text-yellow-700' : 'bg-gray-50 text-gray-600') }}">
                                
                                {{-- Icon kecil di badge --}}
                                @if($item->status == 'in_progress') <x-icon name="o-clock" class="w-3 h-3" /> @endif
                                @if($item->status == 'done') <x-icon name="o-check-circle" class="w-3 h-3" /> @endif
                                
                                {{ $tabs[$item->status] ?? $item->status }}
                            </span>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-2xl border-dashed border-2 border-gray-200">
                    <x-icon name="o-map" class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                    <p class="text-gray-500 font-bold">Belum ada item untuk status ini.</p>
                </div>
            @endforelse

        </div>

        <div class="mt-12 text-center text-gray-400 text-sm">
            Roadmap dapat berubah sewaktu-waktu sesuai prioritas tim.
        </div>

    </div>
</div>