<x-app-layout title="Trang chủ - Moonlit Hotel">
    <!-- Search Section -->
    <div class="relative pt-[106px] lg:pb-[270px] pb-[100px] before:absolute before:content-[''] before:z-10 before:top-0 before:left-0 before:w-full before:h-full before:bg-[rgba(0,8,52,0.65)] is__clip__path">
        <img class="absolute z-0 h-full w-full top-0 left-0" src="{{ asset('assets/images/index-5/banner/banner-bg.webp') }}" alt="">
        <div class="container relative z-10">

        </div>
    </div>
    <!-- Facility Section -->
    <div class="relative lg:p-[120px_0] p-[80px_0] before:absolute before:content-[''] before:w-[48.5%] before:h-[335px] before:bg-gray before:right-0 before:bottom-0 before:-z-10 before:hidden lg:before:block">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-[50px] ">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[50px]">
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/bed.svg') }}" alt="">
                        <a href="#" class="h6 heading text-heading mb-[15px] block">Rooms and Suites</a>
                        <p>Varied types of rooms, from standard to luxury suites, equipped with essentials like beds.</p>
                    </div>
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/security.svg') }}" alt="">
                        <a href="#" class="h6 heading text-heading mb-[15px] block">24-Hour Security</a>
                        <p>On-site security personnel and best surveillance. Secure storage for valuables.</p>
                    </div>
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/gym.svg') }}" alt="">
                        <a href="#" class="h6 heading text-heading mb-[15px] block">Fitness Center</a>
                        <p>Equipped with exercise machines and weights. Offering massages, facials, and other treatments.</p>
                    </div>
                    <div class="item">
                        <img class="mb-[25px]" src="{{ asset('assets/images/icon/swimming-pool.svg') }}" alt="">
                        <a href="#" class="h6 heading text-heading mb-[15px] block">Swimming Pool</a>
                        <p>Indoor or outdoor pools for leisure or exercise. Offering massages, facials, and other treatments.</p>
                    </div>
                </div>
                <div>
                    <div class="mb-[40px]">
                        <span class="heading heading-6 relative mb-[10px] left-[65px] text-primary inline-block
                            before:absolute before:left-[-65px] before:bottom-[50%] before:w-[52px] before:h-[12px]
                            before:bg-no-repeat before:bg-[url('../images/shape/section__style__two.svg')] before:transform before:translate-y-2/4">
                            Facilities
                        </span>
                        <h2 class="text-heading capitalize">Apartment Facilities</h2>
                    </div>
                    <div class="img">
                        <img height="325" width="645" class="" src="{{ asset('assets/images/index-5/facility.webp') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Section -->
    <div class="relative p-[120px_0]">
        <div class="container">
            <div class="flex justify-between items-center flex-wrap gap-[30px] lg:gap-0 mb-[40px]">
                <div>
                    <span class="heading heading-6 relative mb-[15px] left-[65px] text-primary inline-block before:absolute before:left-[-65px] before:bottom-[50%] before:w-[52px] before:h-[12px] before:bg-no-repeat before:bg-[url('../images/shape/section__style__two.svg')] before:transform before:translate-y-2/4">Our Room</span>
                    <h2 class="text-heading capitalize">Our Rooms</h2>
                </div>
                <div>
                    <p class="text-sm max-w-[645px]">
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
                            <div class="relative bg-white shadow-[0_30px_40px_rgba(175,175,175,0.16)]">
                                <div class="img">
                                    <img height="500" width="610" src="{{ asset('assets/images/index-3/apartment/1.webp') }}" alt="apartment">
                                </div>
                                <div class="p-[35px_30px] flex justify-between animate-content hidden">
                                    <div class="flex flex-col gap-[10px]">
                                        <a class='apartment__title anim-1' href='/room-details-2'>
                                            <h5 class="heading text-heading">Elegant Apartment</h5>
                                        </a>
                                        <div class="flex gap-[20px] anim-2">
                                            <span class="flex gap-[10px] items-center"><i class="flaticon-construction"></i>35 sqm</span>
                                            <span class="flex gap-[10px] items-center"><i class="flaticon-user"></i>5 Person</span>
                                        </div>
                                    </div>
                                    <span class="price h4 text-primary heading-4">200$</span>
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
    <div class="relative bg-gray lg:pb-[120px] pb-[80px] service__clip__path pt-[80px] lg:pt-[190px]">
        <div class="container">
            <div class="text-center mb-[40px]">
                <span class="subtitle font-glida heading-6 heading text-primary before:bg-[url('../images/shape/section__style__three-1.svg')] after:bg-[url('../images/shape/section__style__two.svg')]">Our Service</span>
                <h2 class="text-heading mt-[15px]">Our Services</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
                @foreach ([2, 3, 4] as $i)
                    <div class="bg-white rounded-[10px] p-[15px_15px_20px_15px] @if($i == 3) relative lg:top-[50px] top-0 @endif">
                        <div class="thumb">
                            <img class="rounded-[10px]" src="{{ asset('assets/images/index-4/service/' . $i . '.webp') }}" alt="">
                        </div>
                        <div class="flex flex-col gap-[5px] justify-center items-center mt-[30px]">
                            <a href="#" class="heading h5 text-heading">Spa Retreat</a>
                            <span class="heading text-primary h4">120$</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Offers Section -->
    <div class="relative pt-[80px] lg:pt-[120px]">
        <div class="container">
            <div class="flex justify-between items-center flex-wrap gap-[30px] lg:gap-0 mb-[40px]">
                <div>
                    <span class="heading heading-6 relative mb-[10px] left-[65px] text-primary inline-block before:absolute before:left-[-65px] before:bottom-[50%] before:w-[52px] before:h-[12px] before:bg-no-repeat before:bg-[url('../images/shape/section__style__two.svg')] before:transform before:translate-y-2/4">Best Offers</span>
                    <h2 class="text-heading capitalize">Best Offers</h2>
                </div>
                <div>
                    <p class="text-sm max-w-[645px]">
                        Our rooms offer a harmonious blend of comfort and elegance, designed to provide an exceptional stay for every guest. Each room features plush bedding, high-quality linens, and a selection of pillows to ensure a restful night's sleep.
                    </p>
                </div>
            </div>
            <div class="grid gap-[30px] xl:gap-0">
                @foreach ([1, 2] as $i)
                    <div class="flex flex-wrap xl:flex-nowrap @if($i == 2) flex-row-reverse @endif bg-heading">
                        <a href="#" class="thumb w-full xl:w-[50%]">
                            <img class="h-full" src="{{ asset('assets/images/index-5/offer/mask_group' . ($i == 1 ? '-1' : '') . '.webp') }}" alt="">
                        </a>
                        <div class="p-[50px] lg:p-[65px_65px_65px_55px] flex-1">
                            <a href="#" class="h4 heading text-white mb-[15px] block hover:text-primary transition-all duration-300">{{ $i == 1 ? 'Room Service Delight' : 'Velvet Red Reserve' }}</a>
                            <p class="text-white text-sm">Indulge in a vibrant and nutritious medley of the season's freshest vegetables. Our Garden Fresh Vegetable Salad features crisp lettuce, juicy cherry tomatoes, crunchy cucumbers.</p>
                            <div class="pricie-tag w-[50%] mt-[15px] mb-[15px]">
                                <span class="h4 text-primary">{{ $i == 1 ? '220$' : '120$' }}</span>
                                <span class="text-[20px] heading text-primary line-through">{{ $i == 1 ? '42$' : '32$' }}</span>
                            </div>
                            <a class='text-sm text-white font-medium font-jost hover:text-primary border-b-[1px] border-[#fff] hover:border-[rgb(171,138,98)] transition-all duration-300' href='/service'>Buy Now</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="relative p-[90px_0] lg:p-[120px_0]">
        <div class="container">
            <div class="text-center mb-[40px]">
                <span class="subtitle font-glida heading-6 heading text-primary before:bg-[url('../images/shape/section__style__three-1.svg')] after:bg-[url('../images/shape/section__style__two.svg')]">Testimonial</span>
                <h2 class="text-heading mt-[10px]">What Our Client Say</h2>
            </div>
            <div class="flex w-full justify-between items-center">
                <div class="overflow-hidden tm__slider__five max-w-max lg:max-w-[550px] xl:max-w-[830px] relative">
                    <div class="swiper-wrapper">
                        @foreach ([1, 2] as $t)
                            <div class="swiper-slide">
                                <div class="text-[25px] text-primary mb-[20px]">
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star"></i>
                                    <i class="flaticon-star-sharp-half-stroke"></i>
                                </div>
                                <span class="text-[28px] leading-[42px] block">Choosing Bokinn was one of the best decisions we've ever made. They have proven to be a reliable and innovative partner...</span>
                                <div class="mt-[20px]">
                                    <h6 class="heading text-heading">Al Amin Khan</h6>
                                    <span>COO of Apex Solutions</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="slider__navigation">
                        <div class="nav__btn button-next">
                            <img src="{{ asset('assets/images/icon/arrow-left-short.svg') }}" alt="">
                        </div>
                        <div class="nav__btn button-prev">
                            <img src="{{ asset('assets/images/icon/arrow-right-short.svg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="testimonial__author max-w-[265px] overflow-hidden hidden lg:block">
                    <div class="swiper-wrapper">
                        @foreach (["author-2x", "author-4"] as $author)
                            <div class="swiper-slide">
                                <div class="img">
                                    <img class="border-[10px] border-gray h-[300px]" width="265" height="285" src="{{ asset('assets/images/author/' . $author . '.webp') }}" alt="">
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
