<div>
    <x-header title="Manajemen Project" subtitle="Wadah dokumentasi aplikasi client">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Cari project..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-plus" class="btn-primary" wire:click="create" label="Buat Project" />
        </x-slot:actions>
    </x-header>

    @if (session()->has('message'))
        <x-alert icon="o-check" class="alert-success mb-4">
            {{ session('message') }}
        </x-alert>
    @endif

    {{-- Alert Password Baru --}}
    @if (session()->has('new_account_info'))
        <div role="alert" class="alert alert-info mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h3 class="font-bold">Akun Client Baru Dibuat!</h3>
                <div class="text-xs">{{ session('new_account_info') }}</div>
                <div class="text-xs mt-1">Simpan password ini dan kirimkan ke client.</div>
            </div>
        </div>
    @endif

    <x-card>
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Client Owner</th>
                        <th>Status</th> {{-- Kolom Status Tetap Ada di Tabel untuk Monitor --}}
                        <th class="hidden md:table-cell">Deadline</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr wire:key="{{ $project->id }}">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12 bg-base-200">
                                        @if($project->logo)
                                            <img src="{{ asset('storage/' . $project->logo) }}" alt="Logo" />
                                        @else
                                            <div class="grid place-content-center h-full text-xs font-bold text-gray-400">IMG</div>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $project->name }}</div>
                                    <div class="text-xs opacity-50">{{ $project->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-medium">{{ $project->client->name ?? 'Unknown' }}</div>
                            <div class="text-xs opacity-50">{{ $project->client->email ?? '-' }}</div>
                        </td>
                        <td>
                            {{-- Badge Status tetap tampil (Read Only) --}}
                            @php
                                $badgeClass = match($project->status) {
                                    'pending' => 'badge-ghost',
                                    'ongoing' => 'badge-warning',
                                    'finished' => 'badge-success',
                                    default => 'badge-neutral'
                                };
                            @endphp
                            <x-badge value="{{ ucfirst($project->status) }}" class="{{ $badgeClass }}" />
                        </td>
                        <td class="hidden md:table-cell">
                            {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}
                        </td>
                        <td class="text-right">
                            <x-button icon="o-pencil" wire:click="edit({{ $project->id }})" class="btn-ghost btn-sm text-blue-500" />
                            <x-button icon="o-trash" wire:click="delete({{ $project->id }})" 
                                      wire:confirm="Yakin hapus project ini?" 
                                      class="btn-ghost btn-sm text-red-500" />
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-10 text-gray-400">Belum ada project.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $projects->links() }}</div>
    </x-card>

    {{-- MODAL FORM (Clean Version) --}}
    <x-modal wire:model="myModal" title="{{ $projectIdToEdit ? 'Edit Project' : 'Project Baru' }}" separator>
        
        <x-form wire:submit="save">
            
            {{-- Input Email (Auto Create User) --}}
            <x-input label="Email Client" 
                     wire:model="client_email" 
                     icon="o-envelope" 
                     placeholder="email client..." 
                     hint="Akun client dibuat otomatis jika email belum ada." />

            {{-- Input Nama Project --}}
            <x-input label="Nama Project" wire:model="name" icon="o-cube" />

            {{-- Upload Logo --}}
            <x-file label="Logo Project" wire:model="logo" accept="image/png, image/jpeg">
                @if ($logo) 
                    <img src="{{ $logo->temporaryUrl() }}" class="h-20 mt-2 rounded border" />
                @elseif ($oldLogo)
                    <img src="{{ asset('storage/' . $oldLogo) }}" class="h-20 mt-2 rounded border" />
                @endif
            </x-file>

            <x-textarea label="Deskripsi" wire:model="description" placeholder="Catatan singkat..." rows="3" />

            {{-- TIDAK ADA INPUT STATUS & DEADLINE DISINI --}}

            <x-slot:actions>
                <x-button label="Batal" @click="$wire.myModal = false" />
                <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    
    </x-modal>
</div>