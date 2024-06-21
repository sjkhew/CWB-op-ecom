<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Stripe;

use App\Product;
use App\ProductDetail;
use App\ProductSku;
use App\Order;
use App\OrderDetail;
use App\Misc;

class EcomController extends Controller
{
    public function manageProduct(Request $request)
    {
        if($request->ajax()){
            $products = Product::all();
            return DataTables::of($products)->make(true);
        }
        return view('admin.products.manage-product');
    }

    public function editProduct($pid)
    {
        $product = Product::find($pid);
        $productSkus = ProductSku::where('is_active',1)->orderBy('report_full_name')->get();

        return view('admin.products.edit-product',compact('pid','product','productSkus'));
    }

    public function updateProduct(Request $request, $pid)
    {
        $product = Product::find($pid);
        $product->fill($request->all());
        $product->save();

        return redirect(route("admin.edit.product",$pid))->with('status','Data Update Successful');
    }

    public function createProduct()
    {
        $productSkus = ProductSku::where('is_active',1)->orderBy('report_full_name')->get();

        return view('admin.products.create-product',compact('productSkus'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'product_sku_id'=> 'required',
            'is_active'     => 'required',
        ]);

        Product::create($request->all());

        return redirect(route("admin.manage.product"))->with('status','Data Created Successful');
    }

    public function manageProductDetails(Request $request, $pid)
    {
        if($request->ajax()){
            $productDetails = Product::find($pid)->productDetails;
            return DataTables::of($productDetails)
            ->addColumn('name', function ($productDetails) {
                return Product::find($productDetails->product_id)->name;
            })
            ->addColumn('price', function ($productDetails) {
                return number_format($productDetails->price,2);
            })
            ->make(true);
        }

        $product = Product::find($pid);

        if($product == null){
            return redirect(route("admin.home"));
        }

        return view('admin.products.manage-product-details',compact('pid','product'));
    }

    public function editProductDetails($pdid)
    {
        $productDetails = ProductDetail::find($pdid);
        return view('admin.products.edit-product-details',compact('pdid','productDetails'));
    }

    public function updateProductDetails(Request $request, $pdid)
    {
        $request->validate([
            'desc'      => 'required',
            'qty'       => 'required',
            'price'     => 'required',
            'is_active' => 'required',
        ]);

        $productDetail = ProductDetail::find($pdid);
        $productDetail->fill($request->all());
        $productDetail->save();

        return redirect(route("admin.edit.product.details",$pdid))->with('status','Data Update Successful');
    }

    public function createProductDetails($pid)
    {
        $product = Product::find($pid);

        return view('admin.products.create-product-details',compact('product'));
    }

    public function storeProductDetails(Request $request, $pid)
    {
        $request->validate([
            'desc'  => 'required',
            'qty'   => 'required',
            'price' => 'required',
            'is_active' => 'required',
        ]);

        $request->merge(['product_id'=>$pid]);

        ProductDetail::create($request->all());

        return redirect(route("admin.manage.product.details",$pid))->with('status','Data Created Successful');
    }

    public function manageOrder(Request $request)
    {
        if($request->ajax()){
            $orders = Order::all();
            return DataTables::of($orders)
            ->addColumn('created_at', function ($orders) {
                return date('Y-m-d',strtotime($orders->created_at));
            })
            ->addColumn('order_id', function ($orders) {
                return str_pad($orders->id, 5, '0', STR_PAD_LEFT);
            })
            ->addColumn('name', function ($orders) {
                return $orders->customer->first_name.' '.$orders->customer->last_name;
            })
            ->addColumn('payment_intent_id', function ($orders) {
                return !empty($orders->stripe_payment_intent_id) ? $orders->stripe_payment_intent_id : '-';
            })
            ->addColumn('total_amount', function ($orders) {
                return number_format($orders->total_amount,2);
            })
            ->make(true);
        }

        return view('admin.products.manage-order');
    }

    public function manageOrderDetails($oid)
    {
        $order = Order::find($oid);
        return view('admin.products.manage-order-details',compact('order'));
    }

    public function manageMisc()
    {
        $misc = Misc::all()->first();
        return view('admin.misc.index',compact('misc'));
    }

    public function updateMisc(Request $request)
    {
        $request->validate([
            'postal_resend_charges'  => 'required',
        ]);

        $misc = Misc::all()->first();
        $misc->postal_resend_charges = $request->postal_resend_charges;
        $misc->update();

        return redirect(route("admin.manage.misc"))->with('status','Data Updated Successful');
    }

    public function exportInvoice($orderId)
    {
        $order = Order::find($orderId);

        if($order->is_paid === 1){
            $orderId = str_pad($order->id, 5, '0', STR_PAD_LEFT);

            // Use to preview PDF
            // echo view('email.invoice_pdf',compact('order')); die();

            // Use to test download PDF
            $pdf = Pdf::loadView('email.invoice_pdf', compact('order'));
            return $pdf->download('invoice_'.$orderId.'.pdf');
        }else{
            return redirect()->route('admin.manage.order');
        }
    }

}
