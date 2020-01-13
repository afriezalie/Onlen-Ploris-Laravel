<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function loginPage(Request $request) {
        if($request->cookie('remember_login')) {
            $cookie_data = $request->cookie('remember_login');

            if(Auth::loginUsingId($cookie_data)) {
                return redirect()->route('flower.index');
            }
            
            Cookie::queue(Cookie::forget('remember_login'));
        }
        return view('auth.login');
    }

    public function postLogin(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if($request->has('isRememberMe')) {
                return redirect()->route('flower.index')->withCookie(
                    Cookie::make('remember_login', Auth::id(), 60)
                );
            }
            return redirect()->route('flower.index');
        }
        return redirect()->route('login')->withErrors(['login_failed' => 'Wrong username or password.']);
    }

    public function registerPage() {
        return view('auth.register');
    }

    public function postRegister(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|integer|digits_between:8,12',
            'gender' => 'required|in:male,female',
            'address' => 'required|min:10',
            'password' => 'required|alpha_dash|min:5',
            'password_confirmation' => 'required|same:password',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        $image_path = $request->file('image')->store('profile_pictures');

        /*
            Membuat role "member" apabila role dengan nama "member" belum ada.
        */
        $role = Role::where('name', 'member')->first();    
        if($role == null) {
            $role = Role::create([
                'name' => 'member',
            ]);
        }

        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'profile_picture' => $image_path,
            'role_id' => $role->id,
        ]);

        Auth::loginUsingId($new_user->id);

        return redirect()->route('flower.index');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login')->withCookie(Cookie::forget('remember_login'));
    }
    
}
