<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index() {
        return view('user.index', ['users' => User::all()]);
    }

    public function edit() {
        return view('user.edit', ['user' => Auth::user()]);
    }

    public function edit_admin($id) {
        $user = User::find($id);

        if($user == null) {
            return redirect()->route('user.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        return view('user.edit_admin', ['user' => $user]);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|integer|digits_between:8,12',
            'gender' => 'required|in:male,female',
            'address' => 'required|min:10',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        $user = Auth::user();

        $image_path = $request->file('image')->store('profile_pictures');
        Storage::delete($user->profile_picture);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->profile_picture = $image_path;
        $user->save();

        return redirect()->route('flower.index')->with('success', 'Profile updated.');
    }

    public function update_admin(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|integer|digits_between:8,12',
            'gender' => 'required|in:male,female',
            'address' => 'required|min:10',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        $user = User::find($id);

        if($user == null) {
            return redirect()->route('user.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $image_path = $request->file('image')->store('profile_pictures');
        Storage::delete($user->profile_picture);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->profile_picture = $image_path;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated.');
    }

    public function delete($id) {
        $user = User::find($id);

        if($user == null) {
            return redirect()->route('user.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $user_email = $user->email;

        Storage::delete($user->profile_picture);
        $user->delete();

        return redirect()->route('user.index')->with('success', $user_email.' deleted.');
    }

    public function search(Request $request) {
        if($request->q == null) {
            return redirect()->route('user.index');
        }
        
        $search_result = User::where('email', 'LIKE', '%'.$request->q.'%')->get();
        return view('user.search_result', ['users' => $search_result, 'query' => $request->q]);
    }
}
