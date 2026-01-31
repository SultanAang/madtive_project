<div class="flex justify-center gap-10">
    <div class="w-1/4 my-10">
        <div class="py-2">
            <div class="mx-auto">
                <img src="{{ asset('img/logo_madtive.jpg') }}" alt="Your Company" class="mx-auto h-10 w-auto" />
                <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-gray-900">Login</h2>
            </div>
            {{-- Perbaikan Typo: 'success' (double 's') --}}
            @if (session('success'))     
                <div class="p-4 mt-6 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-4">
                {{-- Cukup taruh login di sini --}}
                <form wire:submit="login" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-900">Username</label>
                        <div class="mt-2">
                            <input wire:model="username" id="username" type="text" name="username" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm" />
                            @error('username')
                                <p class="mt-2 text-xs text-red-600"><span class="font-medium">Error:</span> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                        <div class="mt-2">
                            <input wire:model="password" id="password" type="password" name="password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm" />
                            @error('password')
                                <p class="mt-2 text-xs text-red-600"><span class="font-medium">Error:</span> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- Target loading sesuaikan dengan method 'login' --}}
                    <div wire:loading wire:target="login" class="flex justify-center">
                        <div class="px-2 py-1 text-blue-800 text-[10px] font-medium rounded bg-blue-200 animate-pulse">Memproses...</div>
                    </div>
                    <div>
                        {{-- Hapus wire:click.prevent karena sudah ditangani wire:submit di form --}}
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-indigo-600">
                            <svg wire:loading wire:target="login" class="w-4 h-4 text-white animate-spin me-2" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            Login
                        </button>
                        @if (auth()->check())
                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                            <span class="font-medium">Status:</span> Kamu berhasil login sebagai ({{ auth()->user()->name }}).
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>