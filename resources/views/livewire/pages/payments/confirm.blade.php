@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto py-12">
        <h1 class="text-2xl font-semibold mb-6">Xác nhận thanh toán</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <p><strong>Booking #{{ $booking->id }}</strong></p>
            <p>Ngày vào: {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</p>
            <p>Ngày ra: {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</p>
            <p>Số đêm: {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }}</p>
            <p class="mt-4 text-lg">Tổng tiền: <span class="font-bold">{{ number_format($booking->total_price, 0, ',', '.') }}₫</span>
            </p>
        </div>

        <form method="POST" action="{{ route('payments.confirm', $booking) }}">
            @csrf
            {{-- Nếu cần truyền thêm transaction_id hoặc method, thêm hidden input ở đây --}}
            {{-- <input type="hidden" name="transaction_id" value="{{ $payment->id }}"> --}}
            <button
                type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
                Xác nhận & Thanh toán
            </button>
        </form>
    </div>
@endsection
