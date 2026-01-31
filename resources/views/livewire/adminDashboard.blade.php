<div class="space-y-6">
    {{-- ================================================= --}}
    {{-- BAGIAN 1: KARTU STATISTIK (CLICKABLE) --}}
    {{-- ================================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div wire:click="openList('ongoing')" class="cursor-pointer hover:bg-gray-50 transition transform hover:-translate-y-1 bg-white p-5 rounded-lg shadow border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase">Project Berjalan</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $total_active }}</h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </div>

        <div wire:click="openList('pending')" class="cursor-pointer hover:bg-gray-50 transition transform hover:-translate-y-1 bg-white p-5 rounded-lg shadow border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase">Belum Dikerjakan</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $total_pending }}</h3>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div wire:click="openList('clients')" class="cursor-pointer hover:bg-gray-50 transition transform hover:-translate-y-1 bg-white p-5 rounded-lg shadow border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase">Total Klien</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $total_clients }}</h3>
            </div>
            <div class="p-3 bg-green-100 rounded-full text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <div wire:click="openList('overdue')" class="cursor-pointer hover:bg-gray-50 transition transform hover:-translate-y-1 bg-white p-5 rounded-lg shadow border-l-4 border-red-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase">Lewat Deadline</p>
                <h3 class="text-2xl font-bold text-red-600">{{ $total_overdue }}</h3>
            </div>
            <div class="p-3 bg-red-100 rounded-full text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
    </div>


    {{-- ================================================= --}}
    {{-- BAGIAN 2: PROGRESS BARS & ALERTS --}}
    {{-- ================================================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-700">Progress Project Terbaru</h3>
            </div>
            <div class="p-6 space-y-6">
                @forelse($recent_projects as $project)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $project->name }}</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded {{ $project->status == 'finished' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }}">
                            {{ $project->progress }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        {{-- Logika Warna: Hijau jika > 80%, Biru jika lainnya --}}
                        <div class="{{ $project->progress >= 80 ? 'bg-green-600' : 'bg-blue-600' }} h-2.5 rounded-full transition-all duration-500" 
                             style="width: {{ $project->progress }}%"></div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-gray-500 text-sm italic">Belum ada data project.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-red-50 flex items-center justify-between">
                <h3 class="font-bold text-red-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Deadline < 7 Hari!
                </h3>
            </div>
            <div class="p-0">
                @if($urgent_projects->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($urgent_projects as $project)
                        <li class="p-4 hover:bg-red-50 transition flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $project->name }}</p>
                                <p class="text-xs text-gray-500">Client: {{ $project->client->company_name ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                {{-- Hitung Sisa Hari --}}
                                @php 
                                    $daysLeft = \Carbon\Carbon::parse($project->deadline)->diffInDays(now());
                                @endphp
                                <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-1 rounded">
                                    {{ $daysLeft == 0 ? 'Hari Ini!' : $daysLeft . ' Hari Lagi' }}
                                </span>
                                <p class="text-[10px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm">Aman! Tidak ada deadline mendesak.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>


    {{-- ================================================= --}}
    {{-- BAGIAN 3: MODAL POPUP (HIDDEN BY DEFAULT) --}}
    {{-- ================================================= --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            {{ $modalTitle }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 max-h-[60vh] overflow-y-auto">
                    @if(count($selectedProjects) > 0)
                        <ul class="space-y-3">
                            @foreach($selectedProjects as $item)
                                <li class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-indigo-300 transition">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            {{-- Cek apakah ini data CLIENT atau PROJECT --}}
                                            @if(isset($item->company_name))
                                                {{-- Tampilan Client --}}
                                                <p class="font-bold text-gray-800 text-lg">{{ $item->company_name }}</p>
                                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    {{ $item->phone ?? 'Tidak ada no. telp' }}
                                                </div>
                                            @else
                                                {{-- Tampilan Project --}}
                                                <p class="font-bold text-indigo-700 text-lg">{{ $item->name }}</p>
                                                <p class="text-sm text-gray-600 mb-1">
                                                    <span class="font-semibold">Client:</span> {{ $item->client->company_name ?? 'Tanpa Client' }}
                                                </p>
                                                
                                                @if(isset($item->deadline))
                                                    <p class="text-xs inline-flex items-center {{ $item->deadline < now() && $item->status != 'finished' ? 'text-red-600 font-bold bg-red-50 px-2 py-1 rounded' : 'text-gray-500' }}">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                        
                                        {{-- Badge Status (Hanya untuk Project) --}}
                                        @if(isset($item->status))
                                        <div class="text-right">
                                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wide rounded-full 
                                                {{ $item->status == 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                                                  ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $item->status }}
                                            </span>
                                            <div class="text-xs text-gray-400 mt-2">Progress: {{ $item->progress }}%</div>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-10 flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <p>Tidak ada data ditemukan untuk kategori ini.</p>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                    <button wire:click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>