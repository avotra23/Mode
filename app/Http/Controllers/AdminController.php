<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard() {
        $stats = [
            'users' => User::count(),
            'commandes' => Commande::count(),
            'en_attente' => Commande::where('statut', 'en_attente')->count(),
            // Somme totale des achats (tous statuts confondus ou 'livré' selon votre choix)
            'ca_total' => Commande::where('statut', '!=', 'refuse')->sum('prix_total'),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function users() {
        
        $users = User::withCount('commandes')
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,styliste,client'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Utilisateur créé avec succès');
    }

    public function commandes() {
        
        $commandes = Commande::with(['client', 'modele'])->latest()->get();
        return view('admin.commandes.index', compact('commandes'));
    }

    public function validerCommande(Request $request, $id) {
        $commande = Commande::findOrFail($id);
        $commande->update([
            'statut' => 'en_confection',
            'date_prevue' => $request->date_prevue,
            'reponse' => 'Votre commande a été validée. Début de la confection.'
        ]);
        return back()->with('success', 'Commande validée !');
    }

    public function refuserCommande(Request $request, $id) {
        $commande = Commande::findOrFail($id);
        $commande->update([
            'statut' => 'refuse',
            'reponse' => $request->reponse
        ]);
        return back()->with('success', 'Commande refusée.');
    }
}