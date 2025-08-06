<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\RoomStatusEnum;
use App\Services\VnpayService;
use App\Models\Room;
use App\Models\Booking;
use App\Services\VoucherService;
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
                ->with('error', 'Error. Please try again.');
        }

        $finalAmount = $booking->bookingDetail->price - $booking->discount_amount;

        return view('livewire.pages.payments.payment-info', compact('booking', 'finalAmount'));
    }

    public function applyVoucher(Request $request, Booking $booking)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $voucherService = app(VoucherService::class);
        $result = $voucherService->validateVoucher($request->code, $booking);

        if (!$result['valid']) {
            return back()->with('error', 'Invalid voucher code or conditions not met');
        }

        $voucherService->applyVoucher($booking, $result['voucher']);

        return back()->with('success', 'Apply voucher successfully');
    }

    public function removeVoucher(Booking $booking)
    {
        // Kiểm tra booking có voucher không
        if (!$booking->voucher_id) {
            return back()->withErrors(['voucher' => 'No voucher to remove']);
        }

        // Kiểm tra quyền truy cập
        if ($booking->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Kiểm tra trạng thái booking
        if ($booking->status !== BookingStatusEnum::Pending) {
            return back()->withErrors(['voucher' => 'Cannot remove voucher from confirmed booking']);
        }

        try {
            DB::transaction(function() use ($booking) {
                if ($booking->voucher) {
                    $booking->voucher->decrement('used_count');
                }

                $booking->update([
                    'voucher_id' => null,
                    'discount_amount' => 0,
                ]);
            });

            return back()->with('success', 'Voucher removed successfully');

        } catch (\Exception $e) {
            return back()->withErrors(['voucher' => 'Failed to remove voucher. Please try again.']);
        }
    }

    public function processPayment(Request $request, Booking $booking)
    {
        // Kiểm tra quyền truy cập và trạng thái
        abort_if(
            $booking->customer_id !== auth()->id() ||
            $booking->status !==  BookingStatusEnum::Pending,
            403
        );

        $finalAmount = $booking->bookingDetail->price;
        // Nếu là GET request -> hiển thị thông tin
        if ($request->isMethod('get')) {
            return view('livewire.pages.payments.payment-info', compact('booking', 'finalAmount'));
        }

        // Nếu là POST request -> xử lý thanh toán
        DB::transaction(function() use ($booking, &$payment, $finalAmount) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $finalAmount,
                'payment_method' => 'vnpay',
                'status' => 'pending',
                'response_data' => null
            ]);

            $booking->bookingDetail->update(['price' => $finalAmount]);
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
                ->with('error', 'Error. Please try again later');
        }

        try {
            DB::beginTransaction();

            $bookingId = $vnpayData['vnp_TxnRef'];
            $booking = Booking::with('payment')->findOrFail($bookingId);
            $payment = $booking->payment;

            if (!$payment) {
                throw new \Exception('Cannot find payment info');
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

                if ($booking->bookingDetail && $booking->bookingDetail->room) {
                    $booking->bookingDetail->room->status = RoomStatusEnum::Booked;
                }

                DB::commit();

                return redirect()->route('payment.success')
                    ->with('booking', $booking)
                    ->with('success', 'Booking successful. Please wait until we confirm your booking.');
            }

            // Nếu thanh toán thất bại
            $payment->update([
                'status' => 'failed',
                'response_data' => json_encode($vnpayData)
            ]);

            DB::commit();

            return redirect()->route('payment.failed')
                ->with('error', 'Payment error: ' . ($vnpayData['vnp_Message'] ?? 'Undefined error'));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('payment.failed')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán');
        }
    }
    public function success(Request $request)
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect()->route('dashboard')
                ->with('error', 'Cannot find your booking info');
        }

        return view('livewire.pages.payments.success', [
            'title' => 'Payment successful',
            'message' => 'Thanks. Please wait a moment until we confirm your booking.',
            'booking' => $booking,
        ]);
    }

    public function failed(Request $request)
    {
        return view('livewire.pages.payments.failed', [
            'title' => 'Payment error',
            'message' => session('error', 'Error. Please try again later'),
        ]);
    }

}
