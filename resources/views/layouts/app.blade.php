<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Moonlit Hotel' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Flaticon Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon_bokinn.css') }}">
    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    @livewireStyles
    @livewireScripts

</head>
<body class="font-sans antialiased text-gray-900">

{{-- Header --}}
<x-header />

{{-- Nội dung trang --}}
<main>
    @empty($slot)
    @else
        {{ $slot }}
    @endempty
    @yield('content')
</main>

{{-- Footer --}}
<x-footer />

{{-- Scripts --}}
@stack('scripts')
</body>
</html>


