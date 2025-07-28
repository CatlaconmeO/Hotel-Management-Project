<div>
    <button
        wire:click="createPayment"
        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
    >
        Thanh toán VNPay {{ number_format($amount) }} ₫
    </button>
</div>
