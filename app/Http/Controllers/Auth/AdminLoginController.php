<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user =  Auth::guard('admin')->user();
            if ($user->state !== 1) {
                Auth::guard('admin')->logout();
                Toastr::error('Your account is inactive. Contact Administrator!.', 'Failed', ["positionClass" => "toast-top-right", "progressBar" => true, "closeButton" => true]);
                return redirect('/auth/login');
            }
            if ($user->is_deleted === 0) {
                Auth::guard('admin')->logout();
                Toastr::error('Your account is banned.', 'Failed', ["positionClass" => "toast-top-right", "progressBar" => true, "closeButton" => true]);
                return redirect('/auth/login');
            }

            Toastr::success('Login successfully', 'Success', ["positionClass" => "toast-top-right", "progressBar" => true, "closeButton" => true]);
            return redirect()->intended(route('admin.dashboard'));
        }
        Toastr::error('Invalid login credentials', 'Failed', ["positionClass" => "toast-top-right", "progressBar" => true, "closeButton" => true]);
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Toastr::success('Logout successfully', 'Success', ["positionClass" => "toast-top-right", "progressBar" => true, "closeButton" => true]);
        return redirect('/');
    }
}
