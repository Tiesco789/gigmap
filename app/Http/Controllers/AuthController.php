<?php

namespace App\Http\Controllers;

use App\Models\EstablishmentProfile;
use App\Models\MusicianProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        $type = $request->query('type', 'musician');
        return view('auth.register', compact('type'));
    }

    public function register(Request $request)
    {
        $type = $request->input('type', 'musician');

        if ($type === 'musician') {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required|string|min:8|confirmed',
                'state'      => 'nullable|string|max:255',
                'city'       => 'nullable|string|max:255',
                'cep'        => 'nullable|string|max:20',
                'address'    => 'nullable|string|max:255',
            ]);

            $user = User::create([
                'name'     => $validated['first_name'] . ' ' . $validated['last_name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'type'     => 'musician',
            ]);

            MusicianProfile::create([
                'user_id'    => $user->id,
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'state'      => $validated['state'] ?? null,
                'city'       => $validated['city'] ?? null,
                'cep'        => $validated['cep'] ?? null,
                'address'    => $validated['address'] ?? null,
            ]);
        } else {
            $validated = $request->validate([
                'establishment_name' => 'required|string|max:255',
                'cnpj'               => 'nullable|string|max:20',
                'website'            => 'nullable|url|max:255',
                'email'              => 'required|email|unique:users,email',
                'password'           => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name'     => $validated['establishment_name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'type'     => 'establishment',
            ]);

            EstablishmentProfile::create([
                'user_id'            => $user->id,
                'establishment_name' => $validated['establishment_name'],
                'cnpj'               => $validated['cnpj'] ?? null,
                'website'            => $validated['website'] ?? null,
            ]);
        }

        Auth::login($user);

        return redirect()->route('announcements.index')->with('success', 'Conta criada com sucesso! Bem-vindo ao GigMap.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('announcements.index'));
        }

        return back()->withErrors([
            'email' => 'Email ou senha inválidos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
