<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManagerController extends Controller
{
    // Show User Login Form
    public function showUserLogin()
    {
        if(Auth::guard('web')->check()){
            return redirect(route('user.profile'));
        }
        return view('auth.login_user');
    }

    // Handle User Login
    public function loginUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('user.profile'));
        }

        return back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    // Show User Registration Form
    public function showUserRegister()
    {
        return view('auth.register_user');
    }

    // Handle User Registration
    public function registerUser(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('user.profile')->with('success', 'Registration successful!');
    }

    // Show Admin Login Form
    public function showAdminLogin()
    {
        return view('auth.login_admin');
    }

    // Handle Admin Login
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))
            ->withErrors(['error' => 'The provided credentials do not match our records.']);
    }

    // Show Admin Registration Form
    public function showAdminRegister()
    {
        return view('auth.register_admin');
    }

    // Handle Admin Registration
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
        ]);

        $admin = Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Admin registration successful!');
    }

    public function logoutUser(Request $request)
    {
        Auth::guard('web')->logout(); // Logout the user only

        // Only regenerate the token if we're not logged in as admin
        if (!Auth::guard('admin')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('user.login')->with('success', 'Logged out successfully.');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout(); // Logout the admin only

        // Only regenerate the token if we're not logged in as a regular user
        if (!Auth::guard('web')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }

}
