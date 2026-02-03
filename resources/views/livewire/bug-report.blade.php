<div class="bg-white min-h-screen">

    {{-- Custom Animations --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0; /* Start invisible */
        }
        /* Stagger delays for form elements */
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
    </style>

    {{-- Mobile Header --}}
    <div class="lg:hidden p-4 border-b flex items-center sticky top-0 bg-white/95 backdrop-blur-sm z-20 shadow-sm transition-all">
        <label for="main-drawer" class="btn btn-square btn-ghost btn-sm mr-2">
            <x-icon name="o-bars-3" class="w-6 h-6" />
        </label>
        <span class="font-bold">Lapor Bug</span>
    </div>

    <div class="max-w-4xl mx-auto py-12 px-8 lg:px-16">

        {{-- Header Section (Fade In First) --}}
        <div class="mb-12 border-b border-gray-100 pb-8 animate-fade-in-up">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">Lapor Bug / Error</h1>
            <p class="text-gray-500 text-lg leading-relaxed">
                Temukan kendala teknis? Laporkan di sini agar tim developer kami segera memperbaikinya.
            </p>
        </div>

        {{-- Alert Sukses (Pop In) --}}
        @if (session('success'))
            <div class="mb-8 p-5 rounded-xl bg-green-50 text-green-800 border border-green-200 flex items-start gap-4 animate-bounce-in shadow-sm">
                <div class="bg-green-100 p-2 rounded-lg text-green-600 shrink-0">
                    <x-icon name="o-check-circle" class="w-6 h-6" /> 
                </div>
                <div>
                    <h3 class="font-bold text-green-900">Laporan Terkirim!</h3>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form wire:submit="save" class="space-y-8">
            
            {{-- Input Judul (Delay 100ms) --}}
            <div class="animate-fade-in-up delay-100 group" style="animation-fill-mode: forwards;">
                <label class="block mb-3 text-sm font-bold text-gray-700 uppercase tracking-wider group-focus-within:text-indigo-600 transition-colors">Judul Masalah</label>
                <input 
                    type="text" 
                    wire:model="title" 
                    class="w-full bg-white border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 block p-4 shadow-sm placeholder-gray-400 transition-all duration-300 transform focus:-translate-y-1 focus:shadow-md" 
                    placeholder="Contoh: Tidak bisa upload foto profil..."
                >
                @error('title') 
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1 animate-pulse">
                        <x-icon name="o-exclamation-circle" class="w-4 h-4" /> {{ $message }}
                    </p> 
                @enderror
            </div>

            {{-- Input Prioritas (Delay 200ms) --}}
            <div class="animate-fade-in-up delay-200" style="animation-fill-mode: forwards;">
                <label class="block mb-3 text-sm font-bold text-gray-700 uppercase tracking-wider">Tingkat Prioritas</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['low' => ['label' => 'Ringan', 'color' => 'bg-green-100 text-green-600'], 'medium' => ['label' => 'Sedang', 'color' => 'bg-yellow-100 text-yellow-600'], 'high' => ['label' => 'Penting', 'color' => 'bg-orange-100 text-orange-600'], 'critical' => ['label' => 'Kritis', 'color' => 'bg-red-100 text-red-600']] as $value => $props)
                        <label class="cursor-pointer relative group">
                            <input type="radio" wire:model="priority" value="{{ $value }}" class="peer sr-only">
                            
                            {{-- Card Container (Animated Selection) --}}
                            <div class="p-4 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all duration-200 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:bg-indigo-50/30 peer-checked:scale-105 peer-checked:shadow-lg flex flex-col items-center justify-center gap-2 h-full transform active:scale-95">
                                {{-- Dot Indicator --}}
                                <div class="{{ $props['color'] }} p-2 rounded-lg shrink-0 transition-transform duration-300 group-hover:scale-110">
                                    <div class="w-3 h-3 rounded-full bg-current"></div>
                                </div>
                                <span class="font-bold text-gray-700 peer-checked:text-indigo-900 transition-colors">{{ $props['label'] }}</span>
                                
                                {{-- Checkmark Icon (Only shows when selected) --}}
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity duration-300 text-indigo-600">
                                    <x-icon name="o-check-circle" class="w-4 h-4" />
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('priority') 
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1 animate-pulse">
                        <x-icon name="o-exclamation-circle" class="w-4 h-4" /> {{ $message }}
                    </p> 
                @enderror
            </div>

            {{-- Input Deskripsi (Delay 300ms) --}}
            <div class="animate-fade-in-up delay-300 group" style="animation-fill-mode: forwards;">
                <label class="block mb-3 text-sm font-bold text-gray-700 uppercase tracking-wider group-focus-within:text-indigo-600 transition-colors">Kronologi / Detail</label>
                <div class="relative">
                    <textarea 
                        wire:model="description" 
                        rows="6" 
                        class="w-full bg-white border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 block p-4 shadow-sm placeholder-gray-400 leading-relaxed transition-all duration-300 focus:shadow-md"
                        placeholder="Jelaskan langkah-langkah yang Anda lakukan sebelum error muncul..."
                    ></textarea>
                </div>
                @error('description') 
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1 animate-pulse">
                        <x-icon name="o-exclamation-circle" class="w-4 h-4" /> {{ $message }}
                    </p> 
                @enderror
            </div>

            {{-- Input File (Delay 400ms) --}}
            <div class="animate-fade-in-up delay-400" style="animation-fill-mode: forwards;">
                <label class="block mb-3 text-sm font-bold text-gray-700 uppercase tracking-wider">Bukti Screenshot (Opsional)</label>
                
                <div class="w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400 transition-all duration-300 group relative overflow-hidden">
                        
                        {{-- Background Highlight on Hover --}}
                        <div class="absolute inset-0 bg-indigo-50/0 group-hover:bg-indigo-50/30 transition-colors duration-300"></div>

                        @if ($screenshot)
                            <div class="relative w-full h-full p-2 group-hover:opacity-50 transition-opacity z-10">
                                <img src="{{ $screenshot->temporaryUrl() }}" class="w-full h-full object-contain rounded-xl shadow-sm">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform scale-90 group-hover:scale-100">
                                    <span class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold shadow-lg text-gray-800 hover:text-indigo-600">Ganti Gambar</span>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-400 group-hover:text-indigo-600 transition-colors z-10 transform group-hover:-translate-y-1 duration-300">
                                <x-icon name="o-photo" class="w-12 h-12 mb-3 group-hover:scale-110 transition-transform duration-300" />
                                <p class="mb-2 text-sm font-semibold">Klik untuk upload bukti error</p>
                                <p class="text-xs text-gray-400">PNG, JPG (MAX. 2MB)</p>
                            </div>
                        @endif
                        
                        <input id="dropzone-file" type="file" wire:model="screenshot" class="hidden" accept="image/*" />
                    </label>
                </div>

                {{-- Loading State --}}
                <div wire:loading wire:target="screenshot" class="mt-2 flex items-center gap-2 text-indigo-600 text-sm font-medium animate-pulse">
                    <x-icon name="o-arrow-path" class="w-4 h-4 animate-spin" /> Sedang mengupload gambar...
                </div>
                @error('screenshot') 
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <x-icon name="o-exclamation-circle" class="w-4 h-4" /> {{ $message }}
                    </p> 
                @enderror
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100 my-8"></div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end animate-fade-in-up" style="animation-delay: 500ms; animation-fill-mode: forwards;">
                <button 
                    type="submit" 
                    class="w-full md:w-auto text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 font-bold rounded-xl text-lg px-8 py-4 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 active:scale-95 active:shadow-sm"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove class="flex items-center gap-2">
                        <x-icon name="o-paper-airplane" class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" />
                        Kirim Laporan
                    </span>
                    <span wire:loading class="flex items-center gap-2">
                        <x-icon name="o-arrow-path" class="w-5 h-5 animate-spin" />
                        Mengirim...
                    </span>
                </button>
            </div>

        </form>

        {{-- Footer Copyright --}}
        <div class="mt-12 text-center text-xs text-gray-400 animate-fade-in-up" style="animation-delay: 600ms; animation-fill-mode: forwards;">
            &copy; 2026 Madtive Studio.
        </div>

    </div>
</div>