<div>
    {{-- BAGIAN 1: BRANDING / LOGO --}}
    <div class="p-6 pt-8">
        <a href="/" wire:navigate class="font-bold text-xl text-indigo-700 flex items-center gap-3 hover:opacity-80 transition">
            {{-- Ikon Logo --}}
            <div class="bg-indigo-100 p-2 rounded-lg">
                <x-icon name="o-book-open" class="w-6 h-6 text-indigo-600" />
            </div>
            <span>Madtive Docs</span>
        </a>
    </div>

    {{-- BAGIAN 2: MENU NAVIGASI --}}
    <x-menu class="px-3 pb-10">
        
        {{-- Label Group (Opsional, biar rapi) --}}
        <x-menu-separator title="Product Updates" class="mt-2 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider" />

        {{-- RELEASE NOTES --}}
        {{-- Logic: Jika URL mengandung 'release-notes', beri warna background --}}
        <x-menu-item 
            title="Release Notes" 
            icon="o-rocket-launch" 
            link="/release-notes" 
            class="mb-1 {{ request()->is('release-notes*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600' }}" 
        />

        {{-- ROADMAP --}}
        <x-menu-item 
            title="Roadmap" 
            icon="o-map" 
            link="/roadmap" 
            class="mb-1 {{ request()->is('roadmap*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600' }}" 
        />

        <x-menu-separator title="Support Center" class="mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider" />

        {{-- KNOWLEDGE BASE --}}
        <x-menu-item 
            title="Knowledge Base" 
            icon="o-academic-cap" 
            link="/knowledge" 
            class="mb-1 {{ request()->is('knowledge*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600' }}" 
        />

        {{-- FAQ --}}
        <x-menu-item 
            title="F.A.Q" 
            icon="o-question-mark-circle" 
            link="/faq" 
            class="mb-1 {{ request()->is('faq*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600' }}" 
        />

        {{-- BAGIAN 3: FOOTER MENU (Keluar / Kembali) --}}
        <x-menu-separator class="my-4" />

        <x-menu-item 
            title="Kembali ke Aplikasi" 
            icon="o-arrow-left-start-on-rectangle" 
            link="/" 
            class="text-gray-500 hover:text-gray-800 hover:bg-gray-100"
        />
        @auth
        {{-- Tampilkan Nama User --}}
        <div class="px-4 py-2 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
            Logged in as: {{ auth()->user()->name }}
        </div>

        {{-- 1. Siapkan FORM TERSEMBUNYI (Hidden) --}}
        {{-- Kita beri ID unik 'logout-form' agar mudah dipanggil --}}
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>

        {{-- 2. Tombol Menu Normal (Bukan tipe submit, tapi Link biasa) --}}
        {{-- Saat diklik, Javascript akan mencari form diatas dan mengirimnya --}}
        <x-menu-item 
            title="Log Out" 
            icon="o-power" 
            link="#" 
            class="text-red-500 hover:bg-red-50 hover:text-red-700 font-bold"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
        />
    @endauth
    </x-menu>
</div>