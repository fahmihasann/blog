<nav class="bg-white border-b border-gray-200 shadow-sm" aria-label="Main navigation">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-5 px-6 py-5 lg:grid-cols-[1fr_auto_1fr] lg:px-8">

        {{-- Kiri: Logo --}}
        <div class="flex justify-center lg:justify-start">
            <a href="{{ route('home') }}"
               class="text-xl font-bold tracking-tight text-gray-900">
                Portfolio
            </a>
        </div>

        {{-- Tengah: Menu utama --}}
        <div class="flex flex-wrap items-center justify-center gap-x-7 gap-y-3 text-sm font-medium text-gray-500">
            <a href="{{ route('home') }}" class="transition hover:text-black">Home</a>
            <a href="{{ route('about') }}" class="transition hover:text-black">About</a>
            <a href="{{ route('education') }}" class="transition hover:text-black">Education</a>

            @auth
                <a href="{{ route('projects.index') }}" class="transition hover:text-black">
                    Projects
                </a>
            @endauth
        </div>

        {{-- Kanan: Menu akun --}}
        <div class="flex flex-wrap items-center justify-center gap-4 text-sm font-medium lg:justify-self-end">

            @auth

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="whitespace-nowrap text-gray-500 transition hover:text-black">
                        Logout
                    </button>
                </form>

                <a href="{{ route('post.profile-saya') }}"
                   class="whitespace-nowrap text-gray-500 transition hover:text-black">
                    Profil
                </a>

                <span class="whitespace-nowrap font-semibold text-gray-900">
                    Halo, {{ auth()->user()->name }}
                </span>
            @else
                <a href="{{ route('login') }}"
                   class="text-gray-500 transition hover:text-black">
                    Login
                </a>
            @endauth

        </div>
    </div>
</nav>