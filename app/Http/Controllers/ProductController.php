<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Exception;
use Illuminate\Support\Facades\Session;
use Stripe;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        // $products['products'] = Products::all();
        // return view('products_list', $products);
    }

    public function productDetail(Request $request)
    {
        $id = $request->id;
        $data['product'] = Products::find($id);
        return view('product_buy', $data);
    }

    public function productBuy(Request $request)
    {
        $price = (float)$request['product_price'];
       
        try{
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $price,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'order_id' => '6735',
                  ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            
            Session::flash('success', 'Payment successful!');                
            return back();
        } catch(Exception $ex) {            
            Session::flash('failed', 'Payment failed!');                
            return back();
        }
    
    }
    
}
