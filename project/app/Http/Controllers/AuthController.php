<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            "name"     => "required|string|max:255",
            "email"    => "required|unique:users,email|email",
            "password" => "required|min:6|confirmed",
            "role"     => "required|in:admin,student",
        ], [
            "email.unique"      => "Этот Email уже зарегистрирован.",
            "email.required"    => "Email обязателен для заполнения.",
            "name.required"     => "Имя обязательно для заполнения.",
            "password.required" => "Пароль обязателен.",
            "password.confirmed"=> "Пароли не совпадают.",
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password), 
                'role'     => $request->role,
            ]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Аккаунт успешно создан!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Произошла ошибка при регистрации.']);
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Введите Email.',
            'password.required' => 'Введите пароль.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Неверный адрес почты или пароль.',
        ])->onlyInput('email');
    }

  
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}