<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{
    public function getRegisteredUsers(){
        $users = DB::table('users')
            ->join('roles','users.role_id','=','roles.id')
            ->select('users.id as user_id','users.email as email','users.first_name as first_name',
                'users.last_name as last_name','users.phone_number as phone_number','users.address as address',
                'roles.id as role_id','roles.name as role_name')
            ->get();
        $roles = Role::all();
        return view('admin.users.registeredUsers')->with([
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function editUser(Request $request,$id){
        try{
            $user = User::findOrFail($id);
            $roles = Role::all();
            return view('admin.users.editUser')->with([
                'user' => $user,
                'roles' => $roles,
            ]);
        }
        catch (ModelNotFoundException $e){
            return redirect('registeredUsers')->with('error','User not found');
        }
    }

    public function updateUser(Request $request,$id){
        if(!$request->has(['first_name','last_name','role','email'])){
            return redirect('registeredUsers')->with('error','Something went wrong');
        }
        try{
            $user = User::findOrFail($id);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->role_id = $request->input('role');
            $user->update();
            return redirect('/registeredUsers')->with('status','User updated');
        }
        catch(ModelNotFoundException $e){
            return redirect('/registeredUsers')->with('error','User Not Found');
        }
        catch (QueryException $e){
            return redirect('/registeredUsers')->with('error','Field cannot be null');
        }
    }

    public function deleteUser(Request $request,$id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/registeredUsers')->with('status','User deleted');
        }
        catch (ModelNotFoundException $e){
            return redirect('/registeredUsers')->with('error','User Not Found');
        }
        catch (QueryException $e){
            return redirect('/registeredUsers')->with('error','Cannot Delete. This User has many order');
        }
    }
}
