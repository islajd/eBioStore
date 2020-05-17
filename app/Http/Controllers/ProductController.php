<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MeasurementType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Guest Operations
    |--------------------------------------------------------------------------
    */

    public function getProduct($id){
        $product = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->select('products.id as product_id','products.name as name','products.price as price','products.image as image',
                'products.description as description','products.stock as stock','products.created_at as date',
                'products.measurement_id as measurement_id','measurement_types.name as measurement_name',
                'products.category_id as category_id','categories.name as category_name')
            ->where('products.id',$id)
            ->first();

        return view('product.productDetails')->with([
            'product'=>$product,
            'categories'=>Category::all()
        ]);
    }

    public function getProductsByCategory($id){
        $products = DB::table('products')
            ->select('products.id as product_id','products.name as name','products.price as price','products.image as image',
                'products.description as description','products.stock as stock','products.created_at as date',
                'products.measurement_id as measurement_id','measurement_types.name as measurement_name',
                'products.category_id as category_id','categories.name as category_name', 'productOrders.sold')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->join(DB::raw('(select product_id, count(*) as sold from order_details group by product_id) productOrders'), 'productOrders.product_id','=','products.id')
            ->where('category_id',$id)
            ->get();
        $categories = Category::all();
        $measurement_types = MeasurementType::all();
        return view('home')->with([
            'products'=>$products,
            'categories'=>$categories,
            'measurement_types'=>$measurement_types
        ]);
    }

    public function listProducts(){
        $products = DB::table('products')
            ->select('products.id as product_id','products.name as name','products.price as price','products.image as image',
                'products.description as description','products.stock as stock','products.created_at as date',
                'products.measurement_id as measurement_id','measurement_types.name as measurement_name',
                'products.category_id as category_id','categories.name as category_name', 'productOrders.sold')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->join(DB::raw('(select product_id, count(*) as sold from order_details group by product_id) productOrders'), 'productOrders.product_id','=','products.id')
            ->get();

        $categories = Category::all();
        $measurement_types = MeasurementType::all();
        if(count($products)==0){
            return view('home')->with([
                'products'=>$products,
                'categories'=>$categories,
                'measurement_types'=>$measurement_types
            ])->with('error','Didn\'t found any product, visit back latter.');
        }
        return view('home')->with([
            'products'=>$products,
            'categories'=>$categories,
            'measurement_types'=>$measurement_types
        ]);
    }
    /*
    |--------------------------------------------------------------------------
    | Admin Operations
    |--------------------------------------------------------------------------
    */

    public function getProducts(){
        $products = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->select('products.id as product_id','products.name as name','products.price as price','products.image as image',
                'products.description as description','products.stock as stock','products.created_at as date',
                'products.measurement_id as measurement_id','measurement_types.name as measurement_name',
                'products.category_id as category_id','categories.name as category_name')
            ->get();
        $categories = Category::all();
        $measurement_types = MeasurementType::all();
        return view('admin.products.products')->with([
            'products'=>$products,
            'categories'=>$categories,
            'measurement_types'=>$measurement_types
        ]);
    }

    public function saveProduct(Request $request){
        if(!$request->has(['name','price','stock','category','measurement_type'])){
            return redirect('products')->with('error','Something went wrong');
        }
        $product = new Product;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->image = $request->input('image');
        $product->description = $request->input('description');
        $product->stock = $request->input('stock');
        $product->measurement_id = $request->input('measurement_type');
        $product->category_id = $request->input('category');
        $product->save();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = $product->id.$image->getClientOriginalName();
            $image = $image->storeAs('public/product_images',$filename);
            $product->image = $filename;
            $product->update();
        }
        return redirect('products')->with('status','Product Added');
    }


    public function editProduct($id){
        try{
            $product = Product::findOrFail($id);
            $categories = Category::all();
            $measurement_types = MeasurementType::all();
            return view('admin.products.editProduct')->with([
                'product'=>$product,
                'categories'=>$categories,
                'measurement_types' => $measurement_types
            ]);
        }
        catch (ModelNotFoundException $e){
            return redirect('products')->with('error','Product not found');
        }
    }

    public function updateProduct(Request $request,$id){
        if(!$request->has(['name','price','stock','category','measurement_type'])){
            return redirect('products')->with('error','Something went wrong');
        }
        try{
            $product = Product::findOrFail($id);
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->stock = $request->input('stock');
            $product->measurement_id = $request->input('measurement_type');
            $product->category_id = $request->input('category');
            if($request->hasFile('image')){
                if($product->image != null){
                    Storage::delete('public/product_images/'.$product->image);
                }
                $image = $request->file('image');
                $filename = $product->id.$image->getClientOriginalName();
                $image = $image->storeAs('public/product_images',$filename);
                $product->image = $filename;
            }
            $product->update();
            return redirect('products')->with('status','Product Updated');
        }
        catch(ModelNotFoundException $e){
            return redirect('products')->with('error','Product Not Found');
        }

        catch (QueryException $e){
            return redirect('products')->with('error','Field cannot be null');
        }
    }

    public function deleteProduct($id){
        try{
            $product = Product::findOrFail($id);
            $productImage = $product->image; // because if product delete we need to save image path to delete
            $product->delete();
            Storage::delete('public/product_images/'.$productImage);
            return redirect('products')->with('status','Product Deleted');
        }
        catch (ModelNotFoundException $e){
            return redirect('products')->with('error','Product Not Found');
        }
        catch (QueryException $e){
            return redirect('products')->with('error','Cannot Delete. Many Orders Has This Product');
        }
    }

}
