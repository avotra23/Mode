<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show() {
        return view('auth.inscription'); // Votre vue personnalisée
    }

    public function register(Request $request) {
        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Création de l'utilisateur Client
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client', // On force le rôle ici
        ]);

        // 3. Connexion automatique
        Auth::login($user);

        // 4. Redirection vers le catalogue ou le panier
        return redirect()->route('catalogue.index')->with('success', 'Bienvenue chez Ma-Mode !');
    }
}
