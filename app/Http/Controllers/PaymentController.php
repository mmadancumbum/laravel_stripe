<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    public function charge(String $product, $price)
    {
        $user = Auth::user();
        return view('payment',[
                'user'=>$user,
                'intent' => $user->createSetupIntent(),
                'product' => $product,
                'price' => $price
            ]);
    }

    public function processPayment(Request $request, String $product, $price)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        // $user->addPaymentMethod($paymentMethod);

        try
        {
            $user->charge($price*100, $paymentMethod, ['off_session' => true]);
            // $request->user()->charge(
            //     100, $request->paymentMethodId
            // );
        }
        catch (\Exception $e)
        {
            return back()->withErrors(['fail' => 'Error creating subscription. ' . $e->getMessage()]);
        }
        return back()->withSuccess(['success' => 'Payment Successful']);
    }
}