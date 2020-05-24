<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Details;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Operations
    |--------------------------------------------------------------------------
    */

    public function createOrder(){
        $c = new CartController();
        $carts = $c->getCart();

        $userId = Auth::user()->id;
        $order = new Order();
        $order->user_id = $userId;
        $order->date = now();
        $order->status = 'NOT SEND';
        $order->address = session('address');
        $order->save();
        Session::forget('address');

        foreach ($carts as $cart){
            $order_detail = new Order_Details();
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $cart->product_id;
            $order_detail->quantity = $cart->amount;
            $product = Product::where('id',$cart->product_id)->first();
            $order_detail->price = $product->price;
            $order_detail->save();

            $product->stock -= $cart->amount;
            $product->update();
        }
        $c->emptyCart();

    }

    public function getUserOrders(){
        $userId = Auth::user()->id;
        $orders = Order::where('user_id',$userId)->get();
        return $orders;
    }

    public function getDetailsForAnUserOrder($orderId){
        try{
            $order = Order::findOrFail($orderId);
            $userId = Auth::user()->id;
            $order_detail = DB::table('orders')
                ->join('users','users.id','=','orders.user_id')
                ->join('order_details','orders.id','=','order_details.order_id')
                ->join('products','order_details.product_id','=','products.id')
                ->join('categories','products.category_id','=','categories.id')
                ->join('measurement_types','products.measurement_id','=','measurement_types.id')
                ->select(
                    'order_details.id','order_details.price',
                    'order_details.quantity','products.name as name','products.id as product_id',
                    'products.image as image', 'products.description as description',
                    'measurement_types.name as measure'
                )
                ->where([
                    'users.id' => $userId,
                    'orders.id'=>  $orderId
                ])
                ->get();
            $total = 0;
            foreach ($order_detail as $od){
                $total += $od->quantity*$od->price;
            }
            return view('profile.orders')->with([
                'order'=>$order,
                'order_detail'=>$order_detail,
                'total'=>$total
            ]);
        }
        catch (QueryException $e){
            return redirect('profile')->with('error','Something went wrong');
        }
        catch (ModelNotFoundException $e){
            return redirect('profile')->with('error','Something went wrong');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Operations
    |--------------------------------------------------------------------------
    */

    public function getOrders(){
        $orders = Order::all();
        return view('admin.orders.orders')->with('orders',$orders);
    }

    public function getDetailsForAnOrder($orderId){
        try{
            $order_details = DB::table('orders')
                ->join('users','users.id','=','orders.user_id')
                ->join('order_details','orders.id','=','order_details.order_id')
                ->join('products','order_details.product_id','=','products.id')
                ->join('categories','products.category_id','=','categories.id')
                ->join('measurement_types','products.measurement_id','=','measurement_types.id')
                ->select(
                    'order_details.id','order_details.price',
                    'order_details.quantity','products.name as name',
                    'products.image', 'products.description',
                    'measurement_types.name','categories.name'
                )
                ->select(
                    'order_details.id','order_details.price',
                    'order_details.quantity','products.name as name',
                    'products.image', 'products.description',
                    'measurement_types.name as measurement_name','categories.name as category_name'
                )
                ->where('order_details.order_id',$orderId)
                ->get();
            $order = Order::findOrFail($orderId);
            return view('admin.orders.orderDetails')->with([
                'order_details'=>$order_details,
                'order' => $order
            ]);
        }
        catch (QueryException $e){
            return back()->with('error','Something went wrong');
        }
        catch (ModelNotFoundException $e){
            return back()->with('error','Something went wrong');
        }
    }

    public function changeStatus($orderId){
        try{
            $order = Order::findOrFail($orderId);
            if($order->status == 'SEND'){
                $order->status = 'NOT SEND';
            }
            else{
                $order->status = 'SEND';
            }
            $order->update();
            return redirect('orders')->with('status',"Status Changed");
        }
        catch (ModelNotFoundException $e){
            return back();
        }
    }
}
