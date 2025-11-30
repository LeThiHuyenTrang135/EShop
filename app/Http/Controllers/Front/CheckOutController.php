<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Services\Order\OrderServiceInterface;
use App\Services\OrderDetail\OrderDetailServiceInterface;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckOutController extends Controller
{
    private $orderService;
    private $orderDetailService;
    public function __construct(OrderServiceInterface $orderService,
                                OrderDetailServiceInterface $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;   
    }
    public function index()
    {
        $carts = Cart::content();
        $total = Cart::total();
        $subtotal = Cart::subtotal();

        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }


    public function addOrder(Request $request)
{
    // Nếu chọn thanh toán MOMO → chuyển hướng luôn, KHÔNG tạo đơn hàng trước
if ($request->payment_type === 'momo_atm') {

    return redirect()->route('momo_payment', [
        'amount' => $request->amount
    ]);
}


    // ======================================================================
    // 1) TẠO ĐƠN HÀNG (orders) — bảng orders KHÔNG có cột amount
    // ======================================================================
    $orderData = [
        'first_name'     => $request->first_name,
        'last_name'      => $request->last_name,
        'company_name'   => $request->company_name,
        'country'        => $request->country,
        'street_address' => $request->street_address,
        'postcode_zip'   => $request->postcode_zip,
        'town_city'      => $request->town_city,
        'phone'          => $request->phone,
        'email'          => $request->email,
        'payment_type'   => $request->payment_type,
    ];

    $order = $this->orderService->create($orderData);


    // ======================================================================
    // 2) TẠO CHI TIẾT ĐƠN HÀNG (order_details)
    // ======================================================================
    $carts = Cart::content();

    foreach ($carts as $cart) {
        $detailData = [
            'order_id'   => $order->id,
            'product_id' => $cart->id,
            'qty'        => $cart->qty,
            'amount'     => $cart->price,                 // giá 1 sản phẩm
            'total'      => $cart->price * $cart->qty,    // thành tiền sản phẩm
        ];

        $this->orderDetailService->create($detailData);
    }


    // ======================================================================
    // 3) PAY LATER → xóa giỏ → chuyển trang result
    // ======================================================================
    if ($request->payment_type === 'pay_later') {

        Cart::destroy();

        return redirect('checkout/result')
            ->with('notification', 'Success! You will pay on delivery. Please check your email.');
    }


    // ======================================================================
    // 4) ONLINE PAYMENT (nếu bạn làm VNPAY sau này)
    // ======================================================================
    if ($request->payment_type === 'online_payment') {
        // TỰ CODE SAU
    }
}



    public function result()
    {   
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));    
    }


    //momo
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    // public function momo_payment(Request $request)

    // {
    //     $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


    //     $partnerCode = 'MOMOBKUN20180529';
    //     $accessKey = 'klm05TvNBzhg7h7j';
    //     $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    //     $orderInfo = "Thanh toán qua MoMo";
    //     $amount = intval($request->amount);

    //     $orderId = time() ."";
    //     $redirectUrl = "http://127.0.0.1:8000/checkout";
    //     $ipnUrl = "http://127.0.0.1:8000/checkout";
    //     $extraData = "";

        
 

    //     $requestId = time() . "";
    //     $requestType = "captureWallet";
    //     // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //     //before sign HMAC SHA256 signature
    //     $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    //     $signature = hash_hmac("sha256", $rawHash, $secretKey);

    //     $data = array('partnerCode' => $partnerCode,
    //         'partnerName' => "Test",
    //         "storeId" => "MomoTestStore",
    //         'requestId' => $requestId,
    //         'amount' => $amount,
    //         'orderId' => $orderId,
    //         'orderInfo' => $orderInfo,
    //         'redirectUrl' => $redirectUrl,
    //         'ipnUrl' => $ipnUrl,
    //         'lang' => 'vi',
    //         'extraData' => $extraData,
    //         'requestType' => $requestType,
    //         'signature' => $signature);
    //     $result = $this->execPostRequest($endpoint, json_encode($data));
    //     $jsonResult = json_decode($result, true);  // decode json

    //     //Just a example, please check more in there
    //     //return $redirect()->to($jsonResult['payUrl']);
    //     dd($jsonResult);
    //    // header('Location: ' . $jsonResult['payUrl']);
    
           
    // }

//     public function momo_payment(Request $request)
// {
//     $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

//     $partnerCode = 'MOMOBKUN20180529';
//     $accessKey   = 'klm05TvNBzhg7h7j';
//     $secretKey   = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

//     $orderInfo = "Thanh toán qua MoMo";

//     // ⚠ amount phải là số nguyên
//    $amount = intval($request->amount);


//     $orderId    = time() . "";
//     $requestId  = time() . "";
//     $redirectUrl = url('/checkout/result');
//     $ipnUrl      = url('/checkout/result');
//     $extraData   = "";

//     // Dùng ví MoMo (KHÔNG phải ATM)
//     $requestType = "captureWallet";

//     // Tạo rawHash
//     $rawHash = "accessKey=" . $accessKey .
//         "&amount=" . $amount .
//         "&extraData=" . $extraData .
//         "&ipnUrl=" . $ipnUrl .
//         "&orderId=" . $orderId .
//         "&orderInfo=" . $orderInfo .
//         "&partnerCode=" . $partnerCode .
//         "&redirectUrl=" . $redirectUrl .
//         "&requestId=" . $requestId .
//         "&requestType=" . $requestType;

//     $signature = hash_hmac("sha256", $rawHash, $secretKey);

//     $data = [
//         "partnerCode" => $partnerCode,
//         "partnerName" => "MoMo Test",
//         "storeId"     => "MomoTestStore",
//         "requestId"   => $requestId,
//         "amount"      => $amount,
//         "orderId"     => $orderId,
//         "orderInfo"   => $orderInfo,
//         "redirectUrl" => $redirectUrl,
//         "ipnUrl"      => $ipnUrl,
//         "lang"        => "vi",
//         "extraData"   => $extraData,
//         "requestType" => $requestType,
//         "signature"   => $signature
//     ];

//     $result = $this->execPostRequest($endpoint, json_encode($data));

// if ($result === false || trim($result) === "") {
//     return "MoMo không trả về gì. LỖI CURL hoặc cấu hình sai";
// }

// dd([
//     'raw_result' => $result,
//     'json_decode' => json_decode($result, true),
// ]);




// }






}
