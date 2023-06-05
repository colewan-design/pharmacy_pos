<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
session_start();

class UserController extends Controller
{

    public function index(Request $request)
    {
        // first check if you are loggedin and admin user ...
        //return Auth::check();

        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        // return 'here';
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }

        // you are already logged in... so check for if you are an admin user..
        $user = Auth::user();
        $_SESSION["role"] = $user->role->isAdmin;
        $_SESSION["user_id"] = $user->id;
        $_SESSION["user_role"] = $user->role->id;
        // if ($user->role->isAdmin == 0) {
        //     return redirect('/login');
        // }
        if ($request->path() == 'login') {
            return redirect('/dashboard');
        }
     
        return $this->checkForPermission($user, $request);
    }
 
    public function checkForPermission($user, $request)
    {
        $permission = json_decode($user->role->permission);
        $hasPermission = false;

        if (!$permission) return view('welcome');

        return view('welcome');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function createUser(Request $request)
    {
        // validate request
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
            'position' => 'required',
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
            'position' => $request->position,
        ]);
        return $user;
    }
    
    public function editUser(Request $request)
    {
        // validate request
        $this->validate($request, [
            'fullname' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id",
            'password' => 'min:6',
            'role_id' => 'required',
            'position' => 'required',
        ]);
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'position' => $request->position,
        ];
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }
        $user = User::where('id', $request->id)->update($data);
        return $user;
    }

    public function getUsers(Request $request)
    {
        return User::orderBy('id', 'desc')->paginate($request->total);
    }

    public function addRole(Request $request) {
        //validate request
        $this->validate($request, [
            'roleName' => 'required'
        ]);
        return Role::create([
            'roleName' => $request->roleName
        ]);
    }

    public function editRole(Request $request) {
        //validate request
        $this->validate($request, [
            'roleName' => 'required',
            'id' => 'required'
        ]);
        return Role::where('id', $request->id)->update([
            'roleName' => $request->roleName
        ]);
    }

    public function getRoles() {
        return Role::all();
    }
    
    public function getRolesPagination(Request $request) {
        return Role::paginate($request->total);
    }

    public function deleteRole(Request $request) {
        //validate request
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Role::where('id', $request->id)->delete();
    }

    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required',
        ]);
        return Role::where('id', $request->id)->update([
            'permission' => $request->permission,
        ]);
    }

    public function getAllUsers() {
        return User::select('id', 'fullname')->get();
    }

    public function deleteUser(Request $req) {
        $user = user::where('id', $req->id)->delete();
        return $user;
    }
}
