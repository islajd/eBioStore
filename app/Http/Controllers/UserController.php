<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use DB;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Operations
    |--------------------------------------------------------------------------
    */

    public function getProfile(){
        try{
            $userId = Auth::user()->id;
            $user = User::findOrFail($userId);
            $orders = app(\App\Http\Controllers\OrderController::class)->getUserOrders();
            return view('profile.profile')->with([
                'user'=>$user,
                'orders'=> $orders
            ]);
        }
        catch (ModelNotFoundException $e){
            return redirect('/')->with('status','User Not Found');
        }
    }

    public function changeDetails(Request $request){
        if(!$request->has(['email','first_name','last_name','phone_number','address'])){
            return "Something went wrong";
        }
        try{
            $userId = Auth::user()->id;
            $user = User::findOrFail($userId);
            $user->email = $request->input('email');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->phone_number = $request->input('phone_number');
            $user->address = $request->input('address');
            $user->update();
            return redirect('profile')->with('status','Updated');
        }
        catch (ModelNotFoundException $e){
            return redirect('profile')->with('status','User not found');
        }
        catch (QueryException $e){
            return redirect('profile')->with('status','Fields cannot be null');
        }
    }

    public function changePassword(Request $request){
        if(!$request->has(['old_password','new_password','confirm_password'])){
            return redirect('getProfile')->with('status','Something Went Wrong');
        }
        try{
            $userId = Auth::user()->id;
            $user = User::findOrFail($userId);
            $old_password = $request->input('old_password');
            $new_password = $request->input('new_password');
            $confirm_password = $request->input('confirm_password');
            if($old_password==null || $new_password==null || $confirm_password==null){
                return redirect('profile')->with('error','Please Complete Fields');
            }
            if($new_password != $confirm_password){
                return redirect('profile')->with('error','Password Not Match');
            }
            if(Hash::check($old_password,$user->password)){
                $user->password = Hash::make($new_password);
                $user->update();
                return redirect('profile')->with('status','Password Changed');
            }
            else{
                return redirect('profile')->with('error','Old Password Incorrect');
            }
        }
        catch (ModelNotFoundException $e){
            return redirect('profile')->with('error','User Not Found');
        }
        catch (QueryException $e){
            return redirect('profile')->with('error','Fields Cannot Be Null');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Operations
    |--------------------------------------------------------------------------
    */

    public function getUsers(){
        $users = DB::table('users')
            ->join('roles','users.role_id','=','roles.id')
            ->select('users.id as user_id','users.email as email','users.first_name as first_name',
                'users.last_name as last_name','users.phone_number as phone_number','users.address as address',
                'roles.id as role_id','roles.name as role_name')
            ->get();
        return view('admin.users.users')->with([
            'users' => $users,
            'roles' => Role::all()
        ]);
    }

    public function changeRole(Request $request,$id){
        if(!$request->has('role')){
            return redirect('users')->with('error','Something went wrong');
        }
        try{
            $user = User::findOrFail($id);
            $user->role_id = $request->input('role');
            $user->update();
            return redirect('users')->with('status','User updated');
        }
        catch(ModelNotFoundException $e){
            return redirect('users')->with('error','User Not Found');
        }
        catch (QueryException $e){
            return redirect('users')->with('error','Field cannot be null');
        }
    }

    public function deleteUser(Request $request,$id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('users')->with('status','User deleted');
        }
        catch (ModelNotFoundException $e){
            return redirect('users')->with('error','User Not Found');
        }
        catch (QueryException $e){
            return redirect('users')->with('error','Cannot Delete. This User has many order');
        }
    }

}
