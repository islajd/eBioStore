<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MeasurementType;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function index(){
        $products = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->join('measurement_types','products.measurement_id','=','measurement_types.id')
            ->select('products.id as product_id','products.name as name','products.price as price','products.image as image',
                'products.description as description','products.stock as stock','products.created_at as date',
                'products.measurement_id as measurement_id','measurement_types.name as measurement_name',
                'products.category_id as category_id','categories.name as category_name')
            ->get();
        return view('welcome1')->with('products',$products);
    }
}
