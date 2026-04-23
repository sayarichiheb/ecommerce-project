<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (!Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            return redirect()->route('products.index')->with('success', 'Bienvenue !');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function verificationNotice()
    {
        return view('auth.verify-email');
    }

    public function verificationVerify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('products.index');
        }

        $request->user()->markEmailAsVerified();

        return redirect()->route('products.index')->with('success', 'Email vérifié avec succès !');
    }

    public function verificationResend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Email de vérification envoyé !');
    }

public function verificationDemo(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('products.index');
    }

    $request->user()->markEmailAsVerified();

    return redirect()->route('products.index')->with('success', 'Email vérifié avec succès !');
}

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Lien de réinitialisation envoyé !')
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé !')
            : back()->withErrors(['email' => [__($status)]]);
    }

public function showProfile()
{
    $user = Auth::user();
    return view('auth.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'password' => 'nullable|min:6|confirmed',
    ]);

    $data = $request->only('name', 'email');

    if ($request->filled('password')) {
        $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
    }

    Auth::user()->update($data);

    return back()->with('success', 'Profil mis à jour !');
}
}