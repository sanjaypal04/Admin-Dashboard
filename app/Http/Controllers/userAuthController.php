<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function index()
    {
        if(!empty(Auth::check())){
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        Auth::login($user);

        $remember = $request->has('remember') ? true : false;

        return redirect('/dashboard');
    }

    public function login(Request $request)
    {
        // die(Hash::make(12345678));
        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect('/dashboard');
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid Email or Password'], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/'));
    }
}
