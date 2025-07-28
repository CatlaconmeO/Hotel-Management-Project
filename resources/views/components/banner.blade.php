<div class="relative pt-[106px] lg:pb-[270px] pb-[100px] before:absolute before:content-[''] before:z-10 before:top-0 before:left-0 before:w-full before:h-full before:bg-[rgba(0,8,52,0.65)] is__clip__path">
    <img class="absolute z-0 h-full w-full top-0 left-0" src="{{ asset('assets/images/index-5/banner/banner-bg.webp') }}" alt="">
    <div class="container">
        <div class="flex gap-[50px] items-center flex-wrap lg:flex-nowrap">
            <div class="xl:max-w-[740px] lg:max-w-[600px] xl:min-w-[740px] relative z-10">
                <h1 class="heading text-[40px] leading-snug mb-[18px] text-white xl:text-[80px] xl:leading-90 lg:text-[60px] lg:leading-snug md:text-[50px] md:leading-snug sm:text-[40px] sm:leading-snug">Discover Luxury in the Heart of the City</h1>
                <p class="mb-[30px] max-w-[635px] text-[18px] text-white">Choosing Moonlit was one of the best decisions we've ever made. They have proven to be a reliable and innovative partner</p>
                <a href="#" class="anim-4 theme-btn fill btn-style inline-block !border-0 !py-[10px] rounded-[6px]">Discover Room</a>
            </div>

            <!-- Booking Form (to be replaced by Livewire component) -->
            <div class="max-w-[100%] xl:min-w-[500px] lg:min-w-[400px] w-full bg-white p-[30px] rounded-[16px] shadow-[0_30px_30px_rgba(175,175,175,0.16)] relative z-10">
                <h5 class="heading text-heading text-center mb-[30px] mt-[5px]">Book Your Stay</h5>
                <form method="POST" action="#">
                    @csrf
                    <div class="grid gap-[30px]">
                        <!-- Check-in -->
                        <div class="flex justify-between relative w-full p-[14px_20px] bg-gray rounded-[6px]">
                            <label for="check_in" class="block text-[20px] font-glida text-heading">Check In</label>
                            <div class="relative min-w-[160px] max-w-[160px]">
                                <input type="text" id="check_in" name="check_in" class="w-full ml-[20px] bg-gray appearance-none p-[0_5px] outline-none" placeholder="15 Jun 2024" required>
                                <div class="absolute right-[20px] top-[2px]">
                                    <i class="flaticon-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Check-out -->
                        <div class="flex justify-between relative w-full p-[14px_20px] bg-gray rounded-[6px]">
                            <label for="check_out" class="block text-[20px] font-glida text-heading">Check Out</label>
                            <div class="relative min-w-[160px] max-w-[160px]">
                                <input type="text" id="check_out" name="check_out" class="w-full ml-[20px] bg-gray appearance-none p-[0_5px] outline-none" placeholder="20 Jun 2024" required>
                                <div class="absolute right-[20px] top-[2px]">
                                    <i class="flaticon-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Adults -->
                        <div class="flex justify-between relative w-full p-[14px_20px] bg-gray rounded-[6px]">
                            <label for="adult" class="block text-[20px] font-glida text-heading">Adult</label>
                            <div class="relative min-w-[160px] max-w-[160px]">
                                <select name="adult" id="adult" class="w-full ml-[20px] bg-gray appearance-none p-[0_5px] outline-none">
                                    @for ($i = 1; $i <= 9; $i++)
                                        <option value="{{ $i }}">{{ $i }} Person</option>
                                    @endfor
                                </select>
                                <div class="absolute right-[20px] top-[2px]">
                                    <i class="flaticon-user"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Children -->
                        <div class="flex justify-between relative w-full p-[14px_20px] bg-gray rounded-[6px]">
                            <label for="child" class="block text-[20px] font-glida text-heading">Child</label>
                            <div class="relative min-w-[160px] max-w-[160px]">
                                <select name="child" id="child" class="w-full ml-[20px] bg-gray appearance-none p-[0_5px] outline-none">
                                    @for ($i = 0; $i <= 9; $i++)
                                        <option value="{{ $i }}">{{ $i }} Child</option>
                                    @endfor
                                </select>
                                <div class="absolute right-[20px] top-[2px]">
                                    <i class="flaticon-user"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Submit -->
                        <button type="submit" class="theme-btn btn-style fill no-border min-w-[140px] h-[56px] rounded-[6px]">
                            <span>Check Now</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
