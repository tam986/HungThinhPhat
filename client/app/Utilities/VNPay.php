<?php

namespace App\Utilities;

class VNPay
{
    /**
     * Cấu hình
     */
    static $vnp_TmnCode = "2M2S428M"; // Mã định danh merchant kết nối (Terminal Id)
    static $vnp_HashSecret = "NX2HKCMGEHY831G3F31Q6BKSIFHIG01B"; // Secret key
    static $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    static $vnp_Returnurl = "checkout/vnPayCheck"; 
    static $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
    static $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";

    /**
     * Tạo URL thanh toán VNPay
     *
     * @param array $data
     * @return string
     */
    public static function vnpay_create_payment(array $data)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

        $vnp_TxnRef = $data['vnp_TxnRef']; // Mã đơn hàng
        $vnp_OrderInfo = $data['vnp_OrderInfo'];
        $vnp_OrderType = 100000;
        $vnp_Amount = $data['vnp_Amount'] * 100; // Nhân 100 để chuyển sang đơn vị nhỏ nhất (VND)
        $vnp_Locale = 'vn'; // Ngôn ngữ tiếng Việt
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => self::$vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => env('APP_URL') . self::$vnp_Returnurl, // Lấy APP_URL từ .env
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // Thêm vnp_BankCode nếu có
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = self::$vnp_Url . "?" . $query;
        if (isset(self::$vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, self::$vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );

        return $returnData['data'];
    }
}

// Thẻ test:
// Ngân hàng: NCB
// Số thẻ: 9704198526191432198
// Tên chủ thẻ: NGUYEN VAN A
// Ngày phát hành: 07/15
// Mật khẩu OTP: 123456