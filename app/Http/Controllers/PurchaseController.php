<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Product;
use App\ProductDetail;
use App\ProductSku;

class PurchaseController extends Controller
{
    public function purchaseSource()
    {
        return view("product.purchase-source");
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required','first_name' => 'required','last_name' => 'required',
            'address1' => 'required','suburb' => 'required','state' => 'required',
            'postcode' => 'required','country' => 'required','member_id' => 'required',
            'parent_id' => 'required','allow_reports' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'    => $validator->errors(),
            ], 422);
        }

        $requestData = $request->all();

        // Get the allow report SKUs Id list in DB
        $allowSkus = collect([]);
        foreach(json_decode($requestData['allow_reports']) as $key => $val){
            $newAllowSkus = $allowSkus->add($val);
        }
        $productSkus = ProductSku::whereIn('sku', $newAllowSkus)->get();
        $allowSkusId = collect([]);
        foreach($productSkus as $key => $val){
            $newAllowSkusId = $allowSkusId->add($val->id);
        }

        // List and view available product
        $products = Product::whereIn('product_sku_id', $newAllowSkusId)->where('is_active',1)->get();

        // Initialise AJAX check-stock calling parameters
        $data = array();
        $data['time'] = time();
        $data['signature'] = md5(env('BUSINESS_PORTAL_API_KEY').$data['time'].$requestData['member_id']);
        $data['member_id'] = $requestData['member_id'];
        $data['parent_id'] = $requestData['parent_id'];
        $data['url_id'] = $requestData['url_id'];
        $data['referer'] = $request->headers->get('referer');

        // Create referer redirect session
        if (session()->has('return_referer')) {
            session()->forget('return_referer');
        }
        session(['return_referer' => $data['referer']], 600);

        return view("product.purchase-index",compact('products','requestData','data'));
    }

    public function getDealerReport(Request $request)
    {
        // Simulate calling API respond
        $data = [];

        if($request->action == 'get-stock-balance'){
            $data = ['sku' => $request->sku, 'bal' => 100];
        }elseif($request->action == 'adjust-stock-balance'){
            $data = ['data' => 200];
        }

        return response()->json($data);
    }

    public function queryProductDetails(Request $request)
    {
        // Ajax Query product details
        $productDetails = ProductDetail::where(['product_id'=>$request->id,'is_active'=>1])->get();
        return response()->json($productDetails);
    }

    public function purchasePayment(Request $request, Client $client)
    {
        // Make sure data passed count is tally
        if(count($request->products) !== count($request->product_details)){
            return redirect($request->referer);
        }

        // Check each product that bought is sufficient balance on backend
        $time = time() - 3; //Buffer for 3 seconds
        $memberId = $request->member_id;
        $parentId = $request->parent_id;
        $urlId = $request->url_id;
        $signature = md5(env('BUSINESS_PORTAL_API_KEY').$time.$memberId);

        $xErr = 0;
        foreach($request->products as $key => $val){
            $product = Product::find($request->products[$key]);
            $selectedSku = $product->productSku->sku;
            $response = $client->request('POST', env("BUSINESS_PORTAL_DEALER_URL"), [
                'verify' => false,
                'form_params' => [
                    'action' => 'get-stock-balance',
                    'time' => $time,
                    'signature' => $signature,
                    'member_id' => $memberId,
                    'parent_id' => $parentId,
                    'url_id' => $urlId,
                    'sku' => $selectedSku,
                ]
            ]);
            $result = json_decode($response->getbody());

            try{
                if($result->bal == 0){
                    $xErr++;
                }
            }catch(\Exception $e){
                return response()->json($result);
            }
        }

        if($xErr > 0){
            echo '<script language="javascript">';
            echo 'alert("Some stock is insufficient. Please try again.")';
            echo '</script>';
            dump('Redirecting...');
            return redirect($request->referer);
        }

        // Count the sumTotal is more than 0
        $sumTotal = 0;
        foreach($request->products as $key => $val){
            $productDetailsId = $request->product_details[$key];
            $productId = $val;
            $productDetail = ProductDetail::where(['id'=>$productDetailsId,'product_id'=>$productId,'is_active'=>1])->first();
            $sumTotal += $productDetail->price;
        }
        if($sumTotal <= 0){
            return redirect($request->referer);
        }

        // Generate extra Reference ID
        $refId = rand(10001,99999);

        // Initialise tax calculation
        $taxId = 0;

        $taxAmount = 0;
        $totalAmount = $sumTotal;

        if(isset($tax)){
            $taxAmount = 0;
            $totalAmount = 0;
        }

        // Example results
        $order = (object) ['id' => 00123];
        $customer = (object) ['id' => 1, 'email' => 'dev@cell-wellbeing.com', 'first_name' => 'Cell Wellbeing', 'last_name' => 'Dev'];

        $orderDescription = 'CWB - Order #'.str_pad($order->id, 5, '0', STR_PAD_LEFT);
        $orderDescription.= ' #'.$request->first_name;

        $data = array();
        $data['orderId'] = $order->id;
        $data['refId'] = $refId;
        $data['desc'] = $orderDescription;
        $data['customer'] = 'cus_'.$customer->id;
        $data['customerEmail'] = $customer->email;
        $data['customerName'] = $customer->first_name.' '.$customer->last_name;
        $data['postalId'] = 0;
        $data['postalCode'] = 0;
        $data['sum'] = $sumTotal * 100;
        $data['tax'] = $taxAmount * 100;
        $data['amount'] = $totalAmount * 100; // Stripe to use amount, minimum 0.50 USD = 500
        $data['taxId'] = $taxId;

        return view("product.purchase-initial",$data);
    }

    public function returnPayment(Request $request)
    {
        // Example returned results
        $intent = (object) ['status' => 'succeeded', 'metadata' => (object) ['order_id' => 123]];

        if($intent->status == 'succeeded'){

            // Update order
            $this->updateOrder($intent->metadata->order_id);

            // Minus dealer stock on CWB business portal
            $this->minusDealerStock($intent->metadata->order_id);

            // Generate PDF
            $this->exportPdf($intent->metadata->order_id);

            // Send acknowledgement email
            $this->sendEmail($intent->metadata->order_id);

            return redirect()->route("purchase.message")->with(['success'=>'Order successful','order_id'=>$intent->metadata->order_id]);
        }else{
            return redirect()->route("purchase.message")->with('failed',$intent->status);
        }
    }

    public function purchaseMessage()
    {
        return view("product.purchase-message");
    }

    private function updateOrder($orderId)
    {
        // Update order record function
    }

    private function minusDealerStock($orderId)
    {
        // Call Step 5 adjust-stock-balance API
    }

    private function sendEmail($orderId)
    {
        // Send email to customer
    }

    private function exportPdf($orderId)
    {
        // Generate PDF
    }
}
