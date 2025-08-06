<x-app-layout title="Trang chủ - Moonlit Hotel">
    <!-- Banner Section -->
    <div class="relative pt-[106px] lg:pb-[270px] pb-[100px] before:absolute before:content-[''] before:z-10 before:top-0 before:left-0 before:w-full before:h-full before:bg-[rgba(30,64,175,0.75)] is__clip__path">
        <img class="absolute z-0 h-full w-full top-0 left-0 object-cover" src="{{ asset('assets/images/index-5/banner/banner-bg.webp') }}" alt="">
        <div class="container relative z-10">
            <!-- Banner content could go here -->
        </div>
    </div>

    <!-- Facility Section -->
    <div class="relative lg:p-[120px_0] p-[80px_0] bg-white before:absolute before:content-[''] before:w-[48.5%] before:h-[335px] before:bg-gray-50 before:right-0 before:bottom-0 before:-z-10 before:hidden lg:before:block">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-[50px]">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[50px]">
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/bed.svg') }}" alt="">
                        <a href="#" class="text-lg font-medium text-gray-800 mb-[15px] block hover:text-blue-500 transition-colors">Rooms and Suites</a>
                        <p class="text-gray-600">Varied types of rooms, from standard to luxury suites, equipped with essentials like beds.</p>
                    </div>
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/security.svg') }}" alt="">
                        <a href="#" class="text-lg font-medium text-gray-800 mb-[15px] block hover:text-blue-500 transition-colors">24-Hour Security</a>
                        <p class="text-gray-600">On-site security personnel and best surveillance. Secure storage for valuables.</p>
                    </div>
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/gym.svg') }}" alt="">
                        <a href="#" class="text-lg font-medium text-gray-800 mb-[15px] block hover:text-blue-500 transition-colors">Fitness Center</a>
                        <p class="text-gray-600">Equipped with exercise machines and weights. Offering massages, facials, and other treatments.</p>
                    </div>
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/swimming-pool.svg') }}" alt="">
                        <a href="#" class="text-lg font-medium text-gray-800 mb-[15px] block hover:text-blue-500 transition-colors">Swimming Pool</a>
                        <p class="text-gray-600">Indoor or outdoor pools for leisure or exercise. Offering massages, facials, and other treatments.</p>
                    </div>
                </div>
                <div>
                    <div class="mb-[40px]">
                        <span class="text-sm font-medium relative mb-[10px] left-[65px] text-blue-500 inline-block
                            before:absolute before:left-[-65px] before:bottom-[50%] before:w-[52px] before:h-[12px]
                            before:bg-no-repeat before:bg-[url('../images/shape/section__style__two.svg')] before:transform before:translate-y-2/4">
                            Facilities
                        </span>
                        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 capitalize">Apartment Facilities</h2>
                    </div>
                    <div class="img shadow-md rounded-md overflow-hidden">
                        <img height="325" width="645" class="w-full" src="{{ asset('assets/images/index-5/facility.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Section -->
    <div class="relative p-[120px_0] bg-gray-50">
        <div class="container">
            <div class="flex justify-between items-center flex-wrap gap-[30px] lg:gap-0 mb-[40px]">
                <div>
                    <span class="text-sm font-medium relative mb-[15px] left-[65px] text-blue-500 inline-block before:absolute before:left-[-65px] before:bottom-[50%] before:w-[52px] before:h-[12px] before:bg-no-repeat before:bg-[url('../images/shape/section__style__two.svg')] before:transform before:translate-y-2/4">Our Room</span>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 capitalize">Our Rooms</h2>
                </div>
                <div>
                    <p class="text-gray-600 max-w-[645px]">
                        Our rooms offer a harmonious blend of comfort and elegance, designed to provide an exceptional stay for every guest. Each room features plush bedding, high-quality linens, and a selection of pillows to ensure a restful night's sleep.
                    </p>
                </div>
            </div>
        </div>
        <div class="full__width px-4 md:px-0">
            <div class="apartment__slider overflow-hidden">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="swiper-slide">
                            <div class="relative bg-white shadow-md rounded-md overflow-hidden">
                                <div class="img">
                                    <img height="500" width="610" src="{{ asset('assets/images/index-3/apartment/1.webp') }}" alt="apartment">
                                </div>
                                <div class="p-[35px_30px] flex justify-between animate-content hidden">
                                    <div class="flex flex-col gap-[10px]">
                                        <a class='apartment__title anim-1 hover:text-blue-500 transition-colors' href='/room-details-2'>
                                            <h5 class="text-lg font-medium text-gray-800">Elegant Apartment</h5>
                                        </a>
                                        <div class="flex gap-[20px] anim-2 text-gray-600">
                                            <span class="flex gap-[10px] items-center"><i class="flaticon-construction"></i>35 sqm</span>
                                            <span class="flex gap-[10px] items-center"><i class="flaticon-user"></i>5 Person</span>
                                        </div>
                                    </div>
                                    <span class="price text-xl font-semibold text-blue-500">200$</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="rts__pagination">
                    <div class="rts-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="relative bg-white lg:pb-[120px] pb-[80px] service__clip__path pt-[80px] lg:pt-[190px]">
        <div class="container">
            <div class="text-center mb-[40px]">
                <span class="subtitle text-sm font-medium text-blue-500 inline-block">Our Service</span>
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mt-[15px]">Our Services</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
                @foreach ([2, 3, 4] as $i)
                    <div class="bg-white rounded-md p-[15px_15px_20px_15px] shadow-md border border-gray-100 @if($i == 3) relative lg:top-[50px] top-0 @endif">
                        <div class="thumb">
                            <img class="rounded-md w-full" src="{{ asset('assets/images/index-4/service/' . $i . '.webp') }}" alt="">
                        </div>
                        <div class="flex flex-col gap-[5px] justify-center items-center mt-[30px]">
                            <a href="#" class="text-lg font-medium text-gray-800 hover:text-blue-500 transition-colors">Spa Retreat</a>
                            <span class="text-xl font-semibold text-blue-500">120$</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Offers Section -->
    <div class="relative pt-[80px] lg:pt-[120px] bg-gray-50">
        <div class="container">
            <div class="flex justify-between items-center flex-wrap gap-[30px] lg:gap-0 mb-[40px]">
                <div>
                    <span class="text-sm font-medium relative mb-[10px] left-[65px] text-blue-500 inline-block before:absolute before:left-[-65px] before:bottom-[50%] before:w-[52px] before:h-[12px] before:bg-no-repeat before:bg-[url('../images/shape/section__style__two.svg')] before:transform before:translate-y-2/4">Best Offers</span>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 capitalize">Best Offers</h2>
                </div>
                <div>
                    <p class="text-gray-600 max-w-[645px]">
                        Our rooms offer a harmonious blend of comfort and elegance, designed to provide an exceptional stay for every guest. Each room features plush bedding, high-quality linens, and a selection of pillows to ensure a restful night's sleep.
                    </p>
                </div>
            </div>
            <div class="grid gap-[30px] xl:gap-0">
                @foreach ([1, 2] as $i)
                    <div class="flex flex-wrap xl:flex-nowrap @if($i == 2) flex-row-reverse @endif bg-white shadow-md rounded-md overflow-hidden">
                        <a href="#" class="thumb w-full xl:w-[50%]">
                            <img class="h-full object-cover" src="{{ asset('assets/images/index-5/offer/mask_group' . ($i == 1 ? '-1' : '') . '.webp') }}" alt="">
                        </a>
                        <div class="p-[50px] lg:p-[65px_65px_65px_55px] flex-1 bg-gray-800">
                            <a href="#" class="text-xl font-medium text-white mb-[15px] block hover:text-blue-400 transition-colors">{{ $i == 1 ? 'Room Service Delight' : 'Velvet Red Reserve' }}</a>
                            <p class="text-gray-200 text-sm">Indulge in a vibrant and nutritious medley of the season's freshest vegetables. Our Garden Fresh Vegetable Salad features crisp lettuce, juicy cherry tomatoes, crunchy cucumbers.</p>
                            <div class="pricie-tag w-[50%] mt-[15px] mb-[15px]">
                                <span class="text-xl font-semibold text-blue-400">{{ $i == 1 ? '220$' : '120$' }}</span>
                                <span class="text-[20px] text-blue-400 line-through ml-2">{{ $i == 1 ? '42$' : '32$' }}</span>
                            </div>
                            <a class='inline-block bg-white text-blue-500 border border-blue-500 px-4 py-2 rounded-md hover:bg-blue-500 hover:text-white transition-colors shadow-sm text-sm font-medium mt-2' href='/service'>Buy Now</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="relative p-[90px_0] lg:p-[120px_0] bg-white">
        <div class="container">
            <div class="text-center mb-[40px]">
                <span class="text-sm font-medium text-blue-500 inline-block">Testimonial</span>
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mt-[10px]">What Our Client Say</h2>
            </div>
            <div class="flex w-full justify-between items-center">
                <div class="overflow-hidden tm__slider__five max-w-max lg:max-w-[550px] xl:max-w-[830px] relative">
                    <div class="swiper-wrapper">
                        @foreach ([1, 2] as $t)
                            <div class="swiper-slide">
                                <div class="text-[25px] text-blue-500 mb-[20px]">
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star-sharp-half-stroke"></i>
                                </div>
                                <span class="text-[28px] leading-[42px] block text-gray-800">Choosing Bokinn was one of the best decisions we've ever made. They have proven to be a reliable and innovative partner...</span>
                                <div class="mt-[20px]">
                                    <h6 class="text-lg font-medium text-gray-800">Al Amin Khan</h6>
                                    <span class="text-gray-600">COO of Apex Solutions</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="slider__navigation">
                        <div class="nav__btn button-next bg-white text-blue-500 border border-blue-500 p-2 rounded-md hover:bg-blue-500 hover:text-white transition-colors">
                            <img src="{{ asset('assets/images/icon/arrow-left-short.svg') }}" alt="">
                        </div>
                        <div class="nav__btn button-prev bg-white text-blue-500 border border-blue-500 p-2 rounded-md hover:bg-blue-500 hover:text-white transition-colors">
                            <img src="{{ asset('assets/images/icon/arrow-right-short.svg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="testimonial__author max-w-[265px] overflow-hidden hidden lg:block">
                    <div class="swiper-wrapper">
                        @foreach (["author-2x", "author-4"] as $author)
                            <div class="swiper-slide">
                                <div class="img">
                                    <img class="border-4 border-gray-100 rounded-md shadow-md" width="265" height="285" src="{{ asset('assets/images/author/' . $author . '.webp') }}" alt="">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@push('scripts')
    <script>
        flatpickr("#check_in",  { dateFormat: "d M Y" });
        flatpickr("#check_out", { dateFormat: "d M Y" });
    </script>
@endpush
