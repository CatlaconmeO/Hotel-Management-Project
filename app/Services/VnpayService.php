<?php
namespace App\Services;

class VnpayService
{
    protected $vnp_TmnCode;
    protected $vnp_HashSecret;
    protected $vnp_Url;
    protected $vnp_ReturnUrl;

    public function __construct()
    {
        $this->vnp_TmnCode    = env('VNP_TMNCODE');
        $this->vnp_HashSecret = env('VNP_HASHSECRET');
        $this->vnp_Url        = env('VNP_URL');
        $this->vnp_ReturnUrl  = env('VNP_RETURN_URL');
    }

    /**
     * Tạo URL thanh toán và trả về cho client
     */
    public function createPaymentUrl(array $orderData): string
    {
        $vnp_TxnRef = $orderData['order_id'];
        $vnp_OrderInfo = $orderData['order_desc'];
        $vnp_Amount = $orderData['amount'] * 100; // VNPay nhân thêm 100
        $vnp_IpAddr = request()->ip();
        $vnp_CreateDate = now()->format('YmdHis');

        // Chuẩn bị mảng dữ liệu
        $inputData = [
            'vnp_Version'        => '2.1.0',
            'vnp_TmnCode'        => $this->vnp_TmnCode,
            'vnp_Amount'         => $vnp_Amount,
            'vnp_Command'        => 'pay',
            'vnp_CreateDate'     => $vnp_CreateDate,
            'vnp_CurrCode'       => 'VND',
            'vnp_IpAddr'         => $vnp_IpAddr,
            'vnp_Locale'         => 'vn',
            'vnp_OrderInfo'      => $vnp_OrderInfo,
            'vnp_OrderType'      => 'other',
            'vnp_ReturnUrl'      => $this->vnp_ReturnUrl,
            'vnp_TxnRef'         => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $hashData = hash_hmac('sha512', $query, $this->vnp_HashSecret);

        return $this->vnp_Url . '?' . $query . '&vnp_SecureHash=' . $hashData;
    }

    /**
     * Kiểm tra chữ ký trả về từ VNPay
     */
    public function validateResponse(array $data): bool
    {
        $secureHash = $data['vnp_SecureHash'] ?? '';
        unset($data['vnp_SecureHash'], $data['vnp_SecureHashType']);

        ksort($data);
        $hashData = hash_hmac('sha512', urldecode(http_build_query($data)), $this->vnp_HashSecret);

        return strtoupper($hashData) === strtoupper($secureHash);
    }
}
