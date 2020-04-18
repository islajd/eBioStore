<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getProfile(){
        try{
            $userId = Auth::user()->id;
            $user = User::findOrFail($userId);
            return $user;
        }
        catch (ModelNotFoundException $e){
            return 'User not found';
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
            return $user;
        }
        catch (ModelNotFoundException $e){
            return 'User not found';
        }
        catch (QueryException $e){
            return 'Fields cannot be null';
        }
    }

    public function changePassword(/*Request $request*/ $old,$new,$conf){
        // Just For Test, password form should get by Input , uncomment this :)
//        if(!$request->has(['old_password','new_password','confirm_password'])){
//            return "Something went wrong";
//        }
        try{
            $userId = Auth::user()->id;
            $user = User::findOrFail($userId);
//            $old_password = $request->input('old_password');
//            $new_password = $request->input('new_password');
//            $confirm_password = $request->input('confirm_password');
            $old_password = $old;
            $new_password = $new;
            $confirm_password = $conf;
            if($new_password != $confirm_password){
                return "New Password and Confirm Password not match";
            }
            if(Hash::check($old_password,$user->password)){
                $user->password = Hash::make($new_password);
                $user->update();
                return "Password Changed";
            }
            else{
                return "Old password incorrect";
            }
        }
        catch (ModelNotFoundException $e){
            return 'User not found';
        }
        catch (QueryException $e){
            return 'Fields cannot be null';
        }
    }
}
