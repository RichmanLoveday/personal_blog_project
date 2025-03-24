<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthorAuthentication extends Controller
{
    public function index()
    {
        return view('author.dashboard');
    }

    public function create()
    {
        return view('author.login');
    }


    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        return redirect()->intended(route('author.dashboard', absolute: false));
    }


    public function forgetPassword()
    {
        return view('author.forget-password');
    }


    public function passwordResetLinkStore(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => 'required|email',
        ]);


        //? send reset link to the found email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        //? return response messages when link sent or not
        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status), 'status' =>  __($status)]);
    }


    public function newPasswordCreate(Request $request, $token = null)
    {
        $user = User::where('email', $request->email)->first();

        //? handle when user model does not exist
        if (!$user) {
            return redirect()->route('author.password.resetlink')->with('error', 'Email does not exist');
        }

        if (!$token || !Password::tokenExists($user, $token)) {
            return redirect()->route('author.forgetPassword')
                ->with('error', 'Your reset link has expired. Please request a new one');
        }

        $email = $user->email;

        return view('author.reset-password', compact('token', 'email'));
    }


    public function newPasswordStore(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        //? reset user password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );


        //? check the status if succesfull return the user to author login page, else return the user to back to where they came from with error messages

        return $status === Password::PasswordReset
            ? redirect()->route('author.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('author.login');
    }
}