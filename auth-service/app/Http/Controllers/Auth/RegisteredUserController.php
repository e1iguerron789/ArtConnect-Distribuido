<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
         $request->validate([
        'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÑñ ]+$/'],
        'username' => ['required', 'string', 'max:50', 'unique:users,username', 'regex:/^[A-Za-zÑñ0-9_]+$/'],
        'edad' => ['required', 'integer', 'min:5', 'max:120'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'edad' => $request->edad,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol' => 'user',
        'ciudad' => 'Quito',
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect()->route('intereses.create');

    }
}
