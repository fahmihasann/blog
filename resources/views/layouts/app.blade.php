<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="flex-grow p-6 max-w-6xl mx-auto w-full">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>
</html>