<!-- header menu -->
<div class="header sticky top-0 z-50 transition-all duration-300 bg-white shadow-sm border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-3 grid-cols-2 items-center py-5">
            {{-- Left: Navigation --}}
            <div class="main__left flex justify-center gap-8 items-center">
                <a href="{{ route('dashboard') }}" class="nav-btn">
                    Home
                </a>
                <a href="{{ route('hotels.index') }}" class="nav-btn">
                    Hotels
                </a>
                <a href="{{ route('bookings.history') }}" class="nav-btn">
                    History
                </a>
            </div>

            {{-- Center: Logo --}}
            <div class="logo flex justify-center">
                <a href="{{ route('dashboard') }}" class="transition-transform duration-300 hover:scale-105">
                    <img class="h-14" src="{{ asset('assets/images/logo/logo.svg') }}" alt="moonlit">
                </a>
            </div>

            {{-- Right: Auth & My Cart --}}
            <div class="main__right flex justify-center gap-8 items-center">
                @auth
                    {{-- My Profile --}}
                    <a href="{{ route('profile') }}" class="nav-btn">
                        Profile
                    </a>

                    {{-- Logout form --}}
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                        @csrf
                        <button type="submit" class="nav-btn">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- Sign In / Sign Up --}}
                    <a href="{{ route('login') }}" class="nav-btn">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="nav-btn">
                        Sign Up
                    </a>
                @endauth

                {{-- My Cart --}}
                <a class="cart-btn" href="/room-details-1">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span>My Cart</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- header menu end -->

<style>
    /* Modern styling */
    .nav-btn {
        @apply bg-white text-gray-700 border border-gray-200 px-4 py-2.5 rounded-lg hidden lg:flex
        hover:bg-blue-600 hover:text-white hover:border-blue-600
        transition-all duration-300 shadow-sm text-sm font-medium;
    }

    .cart-btn {
        @apply bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700
        transition-all duration-300 shadow-md flex items-center gap-2
        text-sm font-medium transform hover:scale-105;
    }

    .header {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 1023px) {
        .logo {
            justify-content: start;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        const header = document.querySelector('.header');

        // Handle submenu
        menuItems.forEach(item => {
            const submenu = item.querySelector('.submenu');
            if (submenu) {
                item.addEventListener('mouseenter', () => {
                    submenu.classList.remove('hidden');
                });

                item.addEventListener('mouseleave', () => {
                    submenu.classList.add('hidden');
                });
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    });
</script>
