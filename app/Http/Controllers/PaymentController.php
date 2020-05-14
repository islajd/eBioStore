<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All PayPal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class PaymentController extends Controller
{
    public function __construct(){
        /** PayPal api context **/

        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithPayPal(Request $request){
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('ALL')
            ->setTotal($request->get('total'));

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status'))
            ->setCancelUrl(URL::to('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try{
            $payment->create($this->_api_context);
        }
        catch (PayPalConnectionException $ex){
            if(\Config::get('app.debug')){
                \Session::put('error','Connection Timeout');
                return Redirect::to('/');
            }
            else{
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::to('/');
            }
        }

        foreach ($payment->links as $link){
            if($link->getRel() == 'approval_url'){
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id',$payment->getId());

        if(isset($redirect_url)){
            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occured');
        return Redirect::to('/');
    }

    public function getPaymentStatus(){
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            \Session::put('error', 'Payment failed');
            return Redirect::to('/');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            \Session::put('success', 'Payment success');
            return Redirect::to('/');

        }
        \Session::put('error', 'Payment failed');
        return Redirect::to('/');

    }
}
