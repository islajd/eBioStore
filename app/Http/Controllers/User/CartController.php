<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_Details;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request,$productId,$amount){
        try{
            $product = Product::findOrFail($productId);
            if($product->stock < $amount && $amount>0){
                return 'You cannot buy more than stock';
            }
            $cart = new Cart();
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $productId;
            // Amount should get by an input form
//        $cart->amount = $request->input('amount');
            $cart->amount = $amount;
            $cart->save();
            return $cart;
        }
        catch (ModelNotFoundException $e){
            return 'Product Not Found';
        }

    }

    public function getProductsAtCart(){
        $userId = Auth::user()->id;
        $products = DB::table('carts')
            ->join('products','carts.product_id','=','products.id')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->where('carts.user_id',$userId)
            ->select('products.id as product_id','products.name as name','products.price as price','products.image as image',
                'products.description as description','products.stock as stock','products.created_at as date',
                'products.measurement_id as measurement_id','measurement_types.name as measurement_name',
                'products.category_id as category_id','categories.name as category_name')
            ->get();

        return $products;
    }


    public function emptyCart(){
        $userId = Auth::user()->id;
        $cart = Cart::where('user_id',$userId)->delete();
        return $cart;
    }

    public function deleteProductAtCart($productId){
        $userId = Auth::user()->id;
        $cart = Cart::where(['user_id'=>$userId,'product_id'=>$productId])->delete();
        return $cart;
    }

    public function changeAmount($productId,$newAmount){
        try{
            $userId = Auth::user()->id;
            $product = Product::findOrFail($productId);
            if($product->stock < $newAmount && $newAmount>0){
                return 'You cannot buy more than stock';
            }
            $cart = Cart::where(['user_id'=>$userId,'product_id'=>$productId])->update(['amount'=>$newAmount]);
            return $cart;
        }
        catch (ModelNotFoundException $e){
            return 'Product not found';
        }
    }


    public function createOrder(){
        $carts = $this->getCart();
        if(count($carts)==0){
            echo "Card is Empty";
        }
        else{
            try{
                foreach ($carts as $cart) {
                    $product = Product::findOrFail($cart->product_id);
                    if ($cart->amount > $product->stock || $cart->amount == 0) {
                        return "Order Not Completed";
                    }
                }
            }
            catch (ModelNotFoundException $e){
                return "One Product Not Found";
            }

            $userId = Auth::user()->id;
            $order = new Order();
            $order->user_id = $userId;
            $order->date = now();
            $userAddress = Auth::user()->address;
            $order->address = $userAddress;
            $order->save();
            echo 'Order: '.$order;


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

                echo 'Detail: '.$order_detail;
            }
            $this->emptyCart();
        }
    }

    public function getCart(){
        $userId = Auth::user()->id;
        $cart = Cart::where('user_id',$userId)->get();
        return $cart;
    }

}
