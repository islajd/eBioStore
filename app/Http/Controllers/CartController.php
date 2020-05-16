<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_Details;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | User Operations
    |--------------------------------------------------------------------------
    */

    public function addToCart(Request $request,$productId){
        try{
            $product = Product::findOrFail($productId);
            $userId = Auth::user()->id;
            $amount = $request->input('quantity');

            if( Cart::where('user_id',$userId)->where('product_id',$productId)->first() ){
                return back()->with('error','This Product Is At Cart');
            }
            if($product->stock < $amount && $amount>0){
                return back()->with('error','Invalid Value');
            }
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->product_id = $productId;
            $cart->amount = $amount;
            $cart->amount = $amount;
            $cart->save();
            return back()->with('status','Success');
        }
        catch (ModelNotFoundException $e){
            return back()->with('error','Product Not Found');
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
                'products.category_id as category_id','categories.name as category_name',
                'carts.amount as quantity')
            ->get();
        $total = 0;
        foreach ($products as $product){
            $total += ($product->price * $product->quantity);
        }
        return view('cart.cart')->with([
            'products'=>$products,
            'total'=>$total
        ]);
    }


    public function emptyCart(){
        $userId = Auth::user()->id;
        $cart = Cart::where('user_id',$userId)->delete();
        return redirect('cart')->with('status','Cart is Empty');
    }

    public function deleteProductAtCart($productId){
        $userId = Auth::user()->id;
        $cart = Cart::where(['user_id'=>$userId,'product_id'=>$productId])->delete();
        return redirect('cart');
    }

    public function changeAmount($productId,Request $request){
        try{
            $userId = Auth::user()->id;
            $product = Product::findOrFail($productId);
            $newAmount = $request->input('amount');
            if($product->stock < $newAmount && $newAmount>0 ){
                return redirect('cart')->with('status','You cannot buy more than stock');
            }
            if($newAmount<=0 ){
                return redirect('cart')->with('status','Value Error');
            }
            $cart = Cart::where(['user_id'=>$userId,'product_id'=>$productId])->update(['amount'=>$newAmount]);
            return redirect('cart');
        }
        catch (ModelNotFoundException $e){
            return redirect('cart')->with('status','Product Not Found');
        }
    }

    public function checkout(){
        $c = new CartController();
        $carts = $c->getCart();
        try{
            foreach ($carts as $cart) {
                $product = Product::findOrFail($cart->product_id);
                if ($cart->amount > $product->stock || $cart->amount == 0) {
                    return redirect('cart')->with('status','Wrong Quantity Values');
                }
            }
        }
        catch (ModelNotFoundException $e){
            return redirect('cart')->with('status','Something went wrong');
        }
        if(count($carts)==0){
            return redirect('cart')->with('status','Cart Empty');
        }
        $userId = Auth::user()->id;
        $products = DB::table('carts')
            ->join('products','carts.product_id','=','products.id')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->where('carts.user_id',$userId)
            ->select('carts.amount as quantity','products.price as price')
            ->get();
        $total = 0;
        foreach ($products as $product){
            $total += ($product->price * $product->quantity);
        }
        return view('cart.checkout')->with('total',$total);
    }




    public function getCart(){
        $userId = Auth::user()->id;
        $cart = Cart::where('user_id',$userId)->get();
        return $cart;
    }

}
