<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Details;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function createOrder($productId,$quantity){
        try{
//            $product = Product::where('id',$productId)->first();
            $product = Product::findOrFail($productId);
            if($product->stock < $quantity){
                return "Cannot Buy more than stock";
            }
            $userId = Auth::user()->id;
            $order = new Order();
            $order->user_id = $userId;
            $order->date = now();
            $userAddress = Auth::user()->address;
            $order->address = $userAddress;
            $order->save();

            $product->stock -= $quantity;
            $product->update();

            $order_detail = new Order_Details();
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $productId;
            $order_detail->quantity = $quantity;
            $order_detail->price = $product->price;
            $order_detail->save();


            echo $order_detail;
            echo $order;
        }
        catch (ModelNotFoundException $e){
            return 'Product Not Found';
        }
    }

    public function getOrders(){
        $userId = Auth::user()->id;
        $orders = Order::where('user_id',$userId)->get();
//        foreach($orders as $order){
//            $order_details = $this->getDetailsForAnOrder($order->id);
//            $total = 0;
//            foreach ($order_details as $order_detail){
//                $total += ($order_detail->price*$order_detail->quantity);
//            }
//            echo "Order_Id = ".$order->id." Total = ".$total."<br>";
//        }
        return $orders;
    }

    public function getDetailsForAnOrder($orderId){
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
                    'order_details.quantity','products.name as name',
                    'products.image as image', 'products.description as description',
                    'measurement_types.name as measure','categories.name'
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
            return "Something went wrong";
        }
        catch (ModelNotFoundException $e){
            return "Something went wrong";
        }
    }


}
