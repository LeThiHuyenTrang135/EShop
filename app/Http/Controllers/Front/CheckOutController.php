<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Services\Order\OrderServiceInterface;
use App\Services\OrderDetail\OrderDetailServiceInterface;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        if ($request->payment_type === 'momo_payment') {
            return redirect()->route('momo_payment', [
                'amount' => $request->amount
            ]);
        }


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
            'status'         => Constant::order_status_ReceiveOrders,
    'user_id' => Auth::id(),



        ];

        $order = $this->orderService->create($orderData);

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

        // 3) PAY LATER → xóa giỏ → chuyển trang result
        // ======================================================================
        if ($request->payment_type === 'pay_later') {

            //gui mail
            $total = Cart::total();
            $subtotal = Cart::subtotal();
            $this->sendEmail($order, $total, $subtotal);

            Cart::destroy();

            return redirect('checkout/result')
                ->with('notification', 'Success! You will pay on delivery. Please check your email.');
        }

        // 4) ONLINE PAYMENT (nếu  VNPAY sau này)
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


    public function momoPayment(Request $request)
    {   

        if (!$request->amount) {
            return "ERROR: amount is NULL!";
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMOBKUN20180529";
        $accessKey   = "klm05TvNBzhg7h7j";
        $secretKey   = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";


        $orderId = time()."";
        $requestId = time()."";
        $amount = (string)$request->amount;
        $orderInfo = "Thanh toan MoMo QR";
        $redirectUrl = url('/momo/result');
        $ipnUrl = url('/momo/result');
        $extraData = "";
        $requestType = "captureWallet";

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            "partnerCode" => $partnerCode,
            "partnerName" => "MoMo Test",
            "storeId" => "Store001",
            "requestId" => $requestId,
            "amount" => $amount,
            "orderId" => $orderId,
            "orderInfo" => $orderInfo,
            "redirectUrl" => $redirectUrl,
            "ipnUrl" => $ipnUrl,
            "lang" => "vi",
            "extraData" => $extraData,
            "requestType" => $requestType,
            "signature" => $signature
        ];

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);


        if (!isset($jsonResult['payUrl'])) {
        dd("MOMO ERROR:", $jsonResult);
    }


        return redirect()->away($jsonResult['payUrl']);
    }


    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // IMPORTANT!

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);

        // Tắt SSL cho Windows (bắt buộc nếu không có cacert.pem)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);

        if ($result === false) {
            dd("CURL ERROR:", curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }

    public function momoResult(Request $request)
    {
        if ($request->resultCode == 0) {

            //GUI MAIL
            // $order = $this->orderService->find($id);
            // $total = Cart::total();
            // $subtotal = Cart::subtotal();
            // $this->sendEmail($order, $total, $subtotal);


            return "Thanh toán thành công!";
        } else {
            return "Thanh toán thất bại!";
        }
    }

    private function sendEmail($order, $total, $subtotal)
    {
        $email_to = $order->email;

        Mail::send('front.checkout.email', 
            compact('order', 'total', 'subtotal'), 
            function($message) use ($email_to){
                $message->from('lethihtrang998877@gmail.com', 'EShop');
                $message->to($email_to, $email_to);
                $message->subject('Order Notification');
            });
    }


}
