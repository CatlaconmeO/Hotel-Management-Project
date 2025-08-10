<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard'));
    }
}; ?>
<div class="min-h-screen flex items-center justify-center p-4 bg-[#f9f9f9]">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[16px] shadow-[0_30px_30px_rgba(175,175,175,0.16)] overflow-hidden">
            <!-- Header -->
            <div class="bg-[#3B82F6] py-6 px-8 text-center">
                <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
                <p class="text-white mt-2">Login to your Moonlit account</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form wire:submit.prevent="login" class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input wire:model.defer="form.email" type="email" id="email" name="email"
                                   class="pl-10 w-full px-8 py-3 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                   placeholder="you@example.com" required>
                        </div>
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-[#3B82F6] hover:underline" wire:navigate>
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input wire:model.defer="form.password" type="password" id="password" name="password"
                                   class="pl-10 w-full px-8 py-3 rounded-[6px] border border-gray-300 focus:outline-none focus:border-[#3B82F6] transition duration-200"
                                   placeholder="••••••••" required>
                            <button type="button" id="togglePassword" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full bg-[#3B82F6] text-white py-3 px-4 rounded-[6px] font-medium hover:bg-[#937452] transition duration-200">
                        Sign In
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="text-[#3B82F6] hover:underline" wire:navigate>
                            Sign up
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #f9f9f9 0%, #f1f1f1 100%);
            }
        </style>
    @endpush

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
        </script>
    @endpush
</div>
