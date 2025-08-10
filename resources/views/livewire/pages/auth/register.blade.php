<?php

use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $phone = '';
    public string $date_of_birth = '';
    public string $address = '';
    public string $identity_number = '';
    public string $customer_type = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Customer::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'identity_number' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = Customer::create($validated)));

        Auth::login($user);

        $this->redirect(route('verification.notice'));
    }
};
 ?>

<div class="min-h-screen flex items-center justify-center p-4 bg-[#f9f9f9]">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-[16px] shadow-[0_30px_30px_rgba(175,175,175,0.16)] overflow-hidden">
            <!-- Header -->
            <div class="bg-[#3B82F6] py-6 px-8 text-center">
                <h1 class="text-3xl font-bold text-white">Create Account</h1>
                <p class="text-white mt-2">Join Moonlit for exceptional stays</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form wire:submit="register" class="space-y-4">
                    <!-- Personal Information Section -->
                    <div class="mb-2">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Personal Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input wire:model="name" type="text" id="name"
                                       class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                       placeholder="Your Name" required>
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input wire:model="date_of_birth" type="date" id="date_of_birth"
                                       class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                       required>
                            </div>
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input wire:model="phone" type="text" id="phone"
                                       class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                       placeholder="+1 234 567 890" required>
                            </div>
                            <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input wire:model="email" type="email" id="email"
                                       class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                       placeholder="you@example.com" required>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input wire:model="password" type="password" id="password"
                                       class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                       placeholder="••••••••" required>
                                <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                       class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                       placeholder="••••••••" required>
                                <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="mt-6 mb-2">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Contact Information</h2>
                    </div>

{{--                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">--}}
{{--                        <!-- Customer Type -->--}}
{{--                        <div>--}}
{{--                            <label for="customer_type" class="block text-sm font-medium text-gray-700 mb-1">Customer Type</label>--}}
{{--                            <div class="relative">--}}
{{--                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">--}}
{{--                                    <i class="fas fa-user-tag text-gray-400"></i>--}}
{{--                                </div>--}}
{{--                                <select wire:model="customer_type" id="customer_type"--}}
{{--                                        class="pl-10 w-full px-10 py-2.5 rounded-[10px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] focus:ring-1 focus:ring-[#3B82F6] transition duration-200 appearance-none">--}}
{{--                                    <option value="">-- Select Type --</option>--}}
{{--                                    <option value="regular">Regular</option>--}}
{{--                                    <option value="vip">VIP</option>--}}
{{--                                </select>--}}
{{--                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">--}}
{{--                                    <i class="fas fa-chevron-down text-gray-400"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <x-input-error :messages="$errors->get('customer_type')" class="mt-1" />--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-home text-gray-400"></i>
                            </div>
                            <input wire:model="address" type="text" id="address"
                                   class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                   placeholder="123 Main St, City, Country">
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>

                    <!-- Identity Number -->
                    <div>
                        <label for="identity_number" class="block text-sm font-medium text-gray-700 mb-1">Identity Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input wire:model="identity_number" type="text" id="identity_number"
                                   class="pl-10 w-full px-10 py-2.5 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                   placeholder="ID12345678">
                        </div>
                        <x-input-error :messages="$errors->get('identity_number')" class="mt-1" />
                    </div>

                    <!-- Submit -->
                    <div class="mt-8">
                        <button type="submit"
                                class="w-full bg-[#3B82F6] text-white py-3 px-4 rounded-[6px] font-medium hover:bg-blue-600 transition duration-200">
                            Create Account
                        </button>
                    </div>

                    <!-- Footer -->
                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-[#3B82F6] hover:underline" wire:navigate>
                                Sign in
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('togglePassword')?.addEventListener('click', function () {
                const input = document.getElementById('password');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });

            document.getElementById('toggleConfirmPassword')?.addEventListener('click', function () {
                const input = document.getElementById('password_confirmation');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        </script>
    @endpush
</div>
