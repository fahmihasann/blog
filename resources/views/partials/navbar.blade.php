<nav class="bg-white border-b border-gray-200 shadow-sm" aria-label="Main navigation">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5 lg:px-8">

        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-gray-900">
            Portfolio
        </a>

        <div class="flex items-center gap-8 text-sm font-medium text-gray-500">
            <a href="{{ route('home') }}" class="transition hover:text-black">Home</a>
            <a href="{{ route('about') }}" class="transition hover:text-black">About</a>
            <a href="{{ route('education') }}" class="transition hover:text-black">Education</a>
            <a href="{{ route('projects') }}" class="transition hover:text-black">Projects</a>
        </div>

    </div>
</nav>