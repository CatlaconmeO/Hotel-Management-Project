<!-- header top -->
<div class="border-b-[.5px] border-[#E5E5E5] hidden md:block">
    <div class="container mx-auto py-[10px]">
        <div class="flex items-center justify-between">
            <div class="flex gap-[25px]">
                <a class="flex gap-[10px] items-center text-xs" href="tel:+12505550199">
                    <i class="flaticon-phone-flip relative top-[3px]"></i> +12505550199
                </a>
                <a class="flex gap-[10px] items-center text-xs" href="mailto:moonlit@gmail.com">
                    <i class="flaticon-envelope relative top-[3px]"></i> moonlit@gmail.com
                </a>
            </div>
            <div>
                <a class="flex gap-[10px] items-center text-xs" href="#">
                    <i class="flaticon-marker relative top-[2px]"></i>
                    280 Augusta Avenue, M5T 2L9 Toronto, Canada
                </a>
            </div>
        </div>
    </div>
</div>
<!-- header top end -->

<!-- header menu -->
<div class="header transition header__function">
    <div class="container transition">
        <div class="grid lg:grid-cols-3 grid-cols-2 justify-center items-center py-[20px] lg:py-[0]">
            {{-- Left: Navigation --}}
            <div class="main__left flex justify-end gap-[15px] items-center">
                <a href="{{ route('dashboard') }}" class="theme-btn btn-style sm-btn rounded-[6px] border hidden lg:flex hover:text-white">
                    Home
                </a>
                <a href="{{ route('hotels.index') }}" class="theme-btn btn-style sm-btn rounded-[6px] border hidden lg:flex hover:text-white">
                    Hotels
                </a>
                <a href="{{ route('bookings.history') }}" class="theme-btn btn-style sm-btn rounded-[6px] border hidden lg:flex hover:text-white">
                    History
                </a>
            </div>


{{--             Center: Logo --}}
{{--            <div class="logo grid justify-start lg:justify-center">--}}
{{--                <a href="{{ route('home') }}">--}}
{{--                    <img class="logo__class" src="{{ asset('assets/images/logo/logo.svg') }}" alt="moonlit">--}}
{{--                </a>--}}
{{--            </div>--}}

            {{-- Right: Auth & Book Now --}}
            <div class="main__right flex justify-end gap-[15px] items-center">
                @auth

                     {{-- My Profile --}}
                    <a href="{{ route('profile') }}" class="theme-btn btn-style sm-btn rounded-[6px] border hidden lg:flex hover:text-white">
                        Profile
                    </a>

                    {{-- Logout form --}}
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:flex">
                        @csrf
                        <button type="submit" class="theme-btn btn-style sm-btn rounded-[6px] border hover:text-white">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- Sign In / Sign Up --}}
                    <a href="{{ route('login') }}" class="theme-btn btn-style sm-btn rounded-[6px] border hidden lg:flex hover:text-white">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="theme-btn btn-style sm-btn rounded-[6px] border hidden lg:flex hover:text-white">
                        Sign Up
                    </a>
                @endauth

                {{-- Book Now --}}
                <a class="theme-btn btn-style sm-btn fill rounded-[6px]" href="/room-details-1">
                    <span>Book Now</span>
                </a>

                {{-- Mobile menu button --}}
                <button class="theme-btn btn-style sm-btn fill menu__btn rounded-[6px] lg:hidden block" id="menu__btn">
                <span>
                    <img src="{{ asset('assets/images/icon/menu-icon.svg') }}" alt="menu icon">
                </span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- header menu end -->

<style>
    .submenu {
        min-width: 200px;
        z-index: 100;
        transition: opacity 0.2s, visibility 0.2s;
    }

    .menu-item:hover > .submenu {
        display: block !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');

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
    });
</script>
