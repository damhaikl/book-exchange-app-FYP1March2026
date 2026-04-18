<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'studentid' => ['required', 'string', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'education_level' => ['required', 'string'],
            'programme' => ['required', 'string'],
        ]);
        
        $user = User::create([
            'studentid' => $request->studentid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'education_level' => $request->education_level,
            'programme' => $request->programme,
        ]);
        
        auth()->login($user);
        return redirect('/homepage');
    }
}
