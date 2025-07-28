@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12">
        {{-- Thông tin đơn hàng --}}
        <div class="mb-6">
            <h2 class="text-2xl font-semibold">Thanh toán đơn hàng</h2>
            <p>Số tiền: {{ number_format($amount) }} ₫</p>
        </div>
        {{-- Livewire Payment --}}
        @livewire('payment-vnpay', ['amount' => $amount])
    </div>
@endsection
