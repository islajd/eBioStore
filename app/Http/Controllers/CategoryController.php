<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Operations
    |--------------------------------------------------------------------------
    */


    public function getCategories(){
        $categories = Category::all();
        return view('admin.categories.categories')->with('categories',$categories);
    }

    public function saveCategory(Request $request){
        if(!$request->has('name')){
            return redirect('categories')->with('error','Something went Wrong');
        }
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
        return redirect('categories')->with('status','Category Added');
    }

    public function deleteCategory(Request $request,$id){
        try{
            $category = Category::find($id);
            $category->delete();
            return redirect('categories')->with('status','Category Deleted');
        }
        catch (ModelNotFoundException $e){
            return redirect('categories')->with('error','Something went Wrong');
        }
        catch (QueryException $e){
            return redirect('categories')->with('error','Cannot Delete. Many Products Has This Category');
        }
    }
}
