<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{

    private $_api_context;

    public function __construct(){
        /** PayPal api context **/

        $payPal_config = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $payPal_config['client_id'],
                $payPal_config['secret'])
        );
        $this->_api_context->setConfig($payPal_config['settings']);
    }

    public function payWithPayPal(Request $request){
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('total'));

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('Status'))->setCancelUrl(route('Status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try{
            $payment->create($this->_api_context);
        }
        catch (PayPalConnectionException $ex){
            if(config('app.debug')){
                return redirect('checkout')->with('error','Connection Timeout');
            }
            else{
                return redirect('checkout')->with('error','Some error occur, sorry for inconvenient');
            }
        }

        foreach ($payment->links as $link){
            if($link->getRel() == 'approval_url'){
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id',$payment->getId());
        Session::put('address',$request->input('address'));

        if(isset($redirect_url)){
            return Redirect::away($redirect_url);
        }

        return redirect('checkout')->with('error','Unknown error occurred');
    }

    public function getPaymentStatus(Request $request){
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return redirect('checkout')->with('error', 'Payment Cancelled');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $order = new OrderController();
            $order->createOrder();
            return redirect('home')->with('PaymentStatus', 'Payment success');
        }

        return redirect('cart')->with('error', 'Payment failed');

    }
}
