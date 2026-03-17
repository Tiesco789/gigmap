<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load(['musicianProfile', 'establishmentProfile']);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'avatar'           => 'nullable|image|max:2048',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password'     => 'nullable|string|min:8|confirmed',
            'about'            => 'nullable|string|max:500',
            'state'            => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'cep'              => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
        ];

        if ($user->isMusician()) {
            $rules['first_name'] = 'nullable|string|max:255';
            $rules['last_name']  = 'nullable|string|max:255';
        } else {
            $rules['establishment_name'] = 'nullable|string|max:255';
            $rules['cnpj']               = 'nullable|string|max:20';
            $rules['website']            = 'nullable|url|max:255';
        }

        $validated = $request->validate($rules);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Handle password change
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Senha atual incorreta.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->email = $validated['email'];
        $user->save();

        // Update type-specific profile
        if ($user->isMusician()) {
            $profile = $user->musicianProfile ?? $user->musicianProfile()->create(['user_id' => $user->id]);
            $profile->update([
                'first_name' => $validated['first_name'] ?? $profile->first_name,
                'last_name'  => $validated['last_name'] ?? $profile->last_name,
                'about'      => $validated['about'] ?? $profile->about,
                'state'      => $validated['state'] ?? $profile->state,
                'city'       => $validated['city'] ?? $profile->city,
                'cep'        => $validated['cep'] ?? $profile->cep,
                'address'    => $validated['address'] ?? $profile->address,
            ]);
            $user->name = trim(($validated['first_name'] ?? $profile->first_name) . ' ' . ($validated['last_name'] ?? $profile->last_name));
            $user->save();
        } else {
            $profile = $user->establishmentProfile ?? $user->establishmentProfile()->create(['user_id' => $user->id]);
            $profile->update([
                'establishment_name' => $validated['establishment_name'] ?? $profile->establishment_name,
                'cnpj'               => $validated['cnpj'] ?? $profile->cnpj,
                'website'            => $validated['website'] ?? $profile->website,
                'about'              => $validated['about'] ?? $profile->about,
                'state'              => $validated['state'] ?? $profile->state,
                'city'               => $validated['city'] ?? $profile->city,
                'cep'                => $validated['cep'] ?? $profile->cep,
                'address'            => $validated['address'] ?? $profile->address,
            ]);
            $user->name = $validated['establishment_name'] ?? $profile->establishment_name;
            $user->save();
        }

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
