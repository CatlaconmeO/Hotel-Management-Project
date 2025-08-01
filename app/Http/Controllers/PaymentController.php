<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\RoomStatusEnum;
use App\Services\VnpayService;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentController extends Controller
{
    protected $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function info(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('error', 'Đơn đặt phòng này không thể thanh toán lại.');
        }

        return view('livewire.pages.payments.payment-info', compact('booking'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        // Kiểm tra quyền truy cập và trạng thái
        abort_if(
            $booking->customer_id !== auth()->id() ||
            $booking->status !==  BookingStatusEnum::Pending,
            403
        );

        // Nếu là GET request -> hiển thị thông tin
        if ($request->isMethod('get')) {
            return view('livewire.pages.payments.payment-info', compact('booking'));
        }

        // Nếu là POST request -> xử lý thanh toán
        DB::transaction(function() use ($booking, &$payment) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->bookingDetail->price,
                'payment_method' => 'vnpay',
                'status' => 'pending',
                'response_data' => null
            ]);

            $booking->update(['status' => 'confirmed']);
        });

        $vnpUrl = app(VnpayService::class)->createPaymentUrl([
            'order_id'       => $booking->id,
            'order_desc'     => $payment->id,
            'amount'         => $payment->amount,
        ]);

        return redirect()->away($vnpUrl);
    }

    public function handleReturn(Request $request)
    {
        $vnpayData = $request->all();

        $secureHash = $vnpayData['vnp_SecureHash'] ?? '';
        unset($vnpayData['vnp_SecureHash'], $vnpayData['vnp_SecureHashType']);

        ksort($vnpayData);
        $hashData = [];
        foreach ($vnpayData as $key => $value) {
            if ($value && strlen($value) > 0) {
                $hashData[] = urlencode($key) . '=' . urlencode($value);
            }
        }

        $hashString = implode('&', $hashData);
        $computedHash = hash_hmac('sha512', $hashString, env('VNP_HASHSECRET'));

        if ($secureHash !== $computedHash) {
            return redirect()->route('payment.failed')
                ->with('error', 'Hash secret không hợp lệ');
        }

        try {
            DB::beginTransaction();

            $bookingId = $vnpayData['vnp_TxnRef'];
            $booking = Booking::with('payment')->findOrFail($bookingId);
            $payment = $booking->payment;

            if (!$payment) {
                throw new \Exception('Không tìm thấy thông tin thanh toán');
            }

            // Kiểm tra trạng thái giao dịch
            if ($vnpayData['vnp_ResponseCode'] === '00' && $vnpayData['vnp_TransactionStatus'] === '00') {
                // Cập nhật payment
                $payment->update([
                    'status' => PaymentStatusEnum::Completed,
                    'payment_method' => 'vnpay',
                    'paid_amount' => $vnpayData['vnp_Amount'] / 100, // VNPay amount được nhân 100
                    'response_data' => json_encode($vnpayData)
                ]);

//                Cập nhật booking
//                $booking->update([
//                    'status' => 'completed'
//                ]);

                if ($booking->bookingDetail && $booking->bookingDetail->room) {
                    $booking->bookingDetail->room->status = RoomStatusEnum::Booked;
                }

                DB::commit();

                return redirect()->route('payment.success')
                    ->with('booking', $booking)
                    ->with('success', 'Thanh toán thành công');
            }

            // Nếu thanh toán thất bại
            $payment->update([
                'status' => 'failed',
                'response_data' => json_encode($vnpayData)
            ]);

            DB::commit();

            return redirect()->route('payment.failed')
                ->with('error', 'Thanh toán thất bại: ' . ($vnpayData['vnp_Message'] ?? 'Không xác định'));

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment processing error: ' . $e->getMessage());

            return redirect()->route('payment.failed')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán');
        }
    }
    public function success(Request $request)
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect()->route('dashboard')
                ->with('error', 'Không tìm thấy thông tin đặt phòng');
        }

        return view('livewire.pages.payments.success', [
            'title' => 'Thanh toán thành công',
            'message' => 'Thanks. Please check your email for booking details.',
            'booking' => $booking,
        ]);
    }

    public function failed(Request $request)
    {
        return view('livewire.pages.payments.failed', [
            'title' => 'Thanh toán thất bại',
            'message' => session('error', 'Error. Please try again later'),
        ]);
    }

}
