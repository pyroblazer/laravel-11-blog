<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\UserProfile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function loadRegisterForm()
    {
        return view("register");
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            // Add user_id to user_profiles table
            $user_profile = new UserProfile();
            $user_profile->user_id = $user->id;
            $user_profile->save();

            Auth::login($user);
            Auth::user()->sendEmailVerificationNotification();

            return redirect('/registration/form')->with('success', 'A verification email has been sent to your email address!');
        } catch (\Exception $e) {
            return redirect('/registration/form')->with('error', $e->getMessage());
        }
    }

    public function loadLoginPage()
    {
        return view('login-page');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                // Redirect user based on role
                if (auth()->user()->role == 0) {
                    return redirect('/user/home');
                } elseif (auth()->user()->role == 1) {
                    return redirect('/admin/home');
                } else {
                    Auth::logout();
                    return redirect('/login/form')->with('error', 'Error: Invalid role');
                }
            } else {
                return redirect('/login/form')->with('error', 'Wrong user credentials');
            }
        } catch (\Exception $e) {
            return redirect('/login/form')->with('error', $e->getMessage());
        }
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login/form');
    }

    public function forgotPassword()
    {
        return view('forgot-password');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain . '/reset/password?token=' . $token;

            $data = [
                'url' => $url,
                'email' => $request->email,
                'title' => 'Password Reset',
                'body' => 'Please click the link below to reset your password',
            ];

            SendForgotPasswordEmailJob::dispatch($data);

            $passwordReset = new PasswordReset();
            $passwordReset->email = $request->email;
            $passwordReset->token = $token;
            $passwordReset->user_id = $user->id;
            $passwordReset->save();

            return back()->with('success', 'Please check your mail inbox to reset your password');
        } else {
            return redirect('/forgot/password')->with('error', 'Email does not exist!');
        }
    }

    public function loadResetPassword(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->first();

        if ($resetData) {
            $user_data = User::find($resetData->user_id);

            return view('reset-password', compact('user_data'));
        } else {
            return view('404');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);

        try {
            $user = User::find($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete reset token
            PasswordReset::where('email', $request->user_email)->delete();

            return redirect('/login/form')->with('success', 'Password changed successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function load404()
    {
        return view('404');
    }
}
