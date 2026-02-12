@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h1 class="text-5xl font-black text-gray-900 leading-none italic">Mon Atelier</h1>
                <p class="text-gray-500 mt-4 text-lg">Suivi des créations et inventaire des tailles.</p>
            </div>
            <a href="{{ route('styliste.collections.create') }}" class="bg-black text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-600 transition-all shadow-lg">
                + Nouvelle Collection
            </a>
        </div>

        @foreach($collections as $collection)
        <div class="mb-16 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between border-b border-gray-100 gap-4">
                <div class="flex items-center gap-6">
                    <img src="{{ asset('storage/' . $collection->image) }}" class="w-16 h-16 object-cover rounded-2xl shadow-sm">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-800">{{ $collection->nom }}</h2>
                        <span class="text-indigo-600 font-bold uppercase tracking-widest text-xs">{{ $collection->saison }} {{ $collection->annee }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('styliste.collections.edit', $collection->id) }}" class="text-xs font-bold border px-4 py-2 rounded-lg hover:bg-white transition">Modifier</a>
                    <a href="{{ route('styliste.modeles.create', ['collection_id' => $collection->id]) }}" class="text-xs font-bold bg-black text-white px-4 py-2 rounded-lg">+ Ajouter Modèle</a>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($collection->modeles as $modele)
                <div class="group border border-gray-100 rounded-3xl p-4 hover:shadow-xl transition-all">
                    <div class="relative h-56 mb-4 overflow-hidden rounded-2xl">
                        <img src="{{ asset('storage/' . ($modele->images[0] ?? 'default.jpg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                             <a href="{{ route('styliste.modeles.show', $modele->id) }}" class="bg-white text-black px-4 py-2 rounded-full font-bold text-xs">Détails techniques</a>
                        </div>
                    </div>

                    <h3 class="font-bold text-gray-900 mb-1">{{ $modele->nom }}</h3>
                    <p class="text-indigo-600 font-black text-sm mb-4">{{ number_format($modele->prix_base, 0, ',', ' ') }} FCFA</p>

                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($modele->options as $option)
                            @if($option->type == 'taille')
                            <div class="bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100 flex items-center gap-2">
                                <span class="text-[10px] font-bold text-indigo-400">{{ $option->valeur }}</span>
                                <span class="text-[10px] font-black text-indigo-700">{{ $option->pivot->stock }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                        <a href="{{ route('styliste.modeles.edit', $modele->id) }}" class="text-xs font-bold text-gray-400 hover:text-indigo-600">Editer</a>
                        <form action="{{ route('styliste.modeles.destroy', $modele->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-300 hover:text-red-500"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" /></svg></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
