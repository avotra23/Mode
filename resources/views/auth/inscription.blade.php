@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-6">
    <div class="max-w-md w-full bg-white shadow-2xl border border-orange-100 p-10">

        <div class="text-center mb-10">
            <h2 class="text-3xl font-serif italic text-[#2D241E]">Rejoindre l'Atelier</h2>
            <div class="h-0.5 w-10 bg-orange-700 mx-auto mt-2"></div>
            <p class="text-gray-400 text-[10px] uppercase tracking-widest mt-4">Créez votre compte client</p>
        </div>

        <form method="POST" action="{{ route('inscription.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="text-[10px] uppercase font-bold tracking-widest text-gray-400">Nom Complet</label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       class="w-full border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 px-0 py-2">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold tracking-widest text-gray-400">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                       class="w-full border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 px-0 py-2">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold tracking-widest text-gray-400">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 px-0 py-2">
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold tracking-widest text-gray-400">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 px-0 py-2">
            </div>

            <button type="submit" class="w-full bg-[#2D241E] text-white py-4 font-bold uppercase tracking-widest text-xs hover:bg-black transition-all shadow-lg">
                S'inscrire
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-400 text-xs">Déjà membre ?
                <a href="#" @click="openLoginModal = true" class="text-orange-700 font-bold underline">Se connecter</a>
            </p>
        </div>
    </div>
</div>
@endsection
