<div class="bg-white min-h-screen">
    
    {{-- Mobile Header (Tombol Burger Menu) --}}
    <div class="lg:hidden p-4 border-b flex items-center sticky top-0 bg-white z-20">
        <label for="main-drawer" class="btn btn-square btn-ghost btn-sm mr-2">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <span class="font-bold">Release Notes</span>
    </div>

    <div class="max-w-4xl mx-auto py-12 px-8 lg:px-16">

        {{-- Header & Dropdown --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 border-b border-gray-100 pb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">Changelog</h1>
                <p class="text-gray-500">Pilih versi untuk melihat detail perubahan.</p>
            </div>

            {{-- === DROPDOWN PEMILIH VERSI === --}}
            <div class="w-full md:w-64">
                <x-select 
                    label="Pilih Versi"
                    icon="o-tag"
                    :options="$versionList"
                    wire:model.live="selectedVersionId"
                    option-label="version"
                    option-value="id"
                    class="font-bold"
                />
            </div>
        </div>

        {{-- AREA KONTEN --}}
        @if($selectedRelease)
            <div wire:key="release-{{ $selectedRelease->id }}" class="animate-fade-in-up">
                
                {{-- Header Rilis Single --}}
                <div class="mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500 uppercase font-bold tracking-wider mb-1">
                            Current Version
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-black text-4xl text-indigo-600">{{ $selectedRelease->version }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-400 font-bold uppercase mb-1">Released Date</div>
                        <div class="font-semibold text-gray-700">
                            {{ $selectedRelease->published_at->format('d F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Intro Text --}}
                <div class="prose prose-lg prose-indigo text-gray-600 leading-relaxed mb-12 max-w-none">
                    {!! $selectedRelease->intro_text !!}
                </div>

                {{-- Grid Fitur --}}
                @if($selectedRelease->features)
                    <h3 class="font-bold text-gray-900 text-xl mb-6 flex items-center gap-2">
                        <x-icon name="o-sparkles" class="w-6 h-6 text-yellow-500" />
                        What's New
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                        @foreach($selectedRelease->features as $feature)
                        <div class="flex items-start gap-4 p-5 rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition duration-200">
                            <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600 shrink-0">
                                <x-icon name="o-check" class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">
                                    {{ $feature['title'] ?? 'Fitur Baru' }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                    {{ $feature['description'] ?? '' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @else
            {{-- State Kosong --}}
            <div class="text-center py-20 bg-gray-50 rounded-xl border-dashed border-2 border-gray-200">
                <x-icon name="o-face-frown" class="w-12 h-12 text-gray-300 mx-auto mb-4" />
                <p class="text-gray-500 font-bold">Belum ada rilis yang dipublish.</p>
            </div>
        @endif

        {{-- Footer Copyright --}}
        <div class="mt-12 text-center text-xs text-gray-400">
            &copy; 2026 Madtive Studio.
        </div>

    </div>
</div>