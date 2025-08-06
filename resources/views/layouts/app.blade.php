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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    @livewireStyles
    @livewireScripts

</head>
<body class="font-sans antialiased text-gray-900">

{{-- Header --}}
<x-header />
@if (session('success'))
    <div
        id="flash-notification"
        class="fixed top-6 right-6 z-50 w-full max-w-sm bg-green-500 text-white rounded-lg shadow-xl overflow-hidden notification"
        style="animation: slideIn 0.3s ease-out forwards;"
    >
        <div class="p-4 flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon-o-check-circle class="w-5 h-5 text-white" />
            </div>
            <div class="ml-3 flex-1 pt-0.5">
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="dismissFlash()" class="ml-4 text-white hover:text-green-200 focus:outline-none">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>
        <div class="progress-bar"></div>
    </div>
@endif
@if (session('error'))
    <div
        id="flash-notification-error"
        class="fixed top-6 right-6 z-50 w-full max-w-sm bg-red-500 text-white rounded-lg shadow-xl overflow-hidden notification"
        style="animation: slideIn 0.3s ease-out forwards;"
    >
        <div class="p-4 flex items-start">
            <div class="flex-shrink-0">
                <x-heroicon-o-x-circle class="w-5 h-5 text-white" />
            </div>
            <div class="ml-3 flex-1 pt-0.5">
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            <button onclick="dismissFlashError()" class="ml-4 text-white hover:text-red-200 focus:outline-none">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>
        <div class="progress-bar-error"></div>
    </div>
@endif


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
<style>
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    .notification.fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
    .progress-bar {
        height: 3px;
        background: rgba(255, 255, 255, 0.2);
        position: relative;
    }
    .progress-bar::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: white;
        animation: progress 5s linear forwards;
    }
    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }
    .progress-bar-error {
        height: 3px;
        background: rgba(255, 255, 255, 0.2);
        position: relative;
    }
    .progress-bar-error::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: white;
        animation: progress 5s linear forwards;
    }
    </style>
<script>
    function dismissFlash() {
        const alert = document.getElementById('flash-notification');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }
    }
    window.addEventListener('DOMContentLoaded', () => {
        // Handle success notification
        const successAlert = document.getElementById('flash-notification');
        if (successAlert) {
            setTimeout(() => {
                dismissFlash();
            }, 5000);
        }

        // Handle error notification
        const errorAlert = document.getElementById('flash-notification-error');
        if (errorAlert) {
            setTimeout(() => {
                dismissFlashError();
            }, 5000);
        }
    });
    function dismissFlashError() {
        const alert = document.getElementById('flash-notification-error');
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }
    }
</script>

{{-- Scripts --}}
@stack('scripts')
</body>
</html>


