<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
            return "Something went wrong";
        }
        catch (ModelNotFoundException $e){
            return "Something went wrong";
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
            return redirect('getOrders')->with('status',"Status Changed");
        }
        catch (ModelNotFoundException $e){

        }
    }
}
