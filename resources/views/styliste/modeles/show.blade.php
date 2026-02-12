@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <div class="grid grid-cols-2 gap-4">
                @foreach($modele->images as $img)
                <div class="rounded-[2.5rem] overflow-hidden shadow-2xl {{ $loop->first ? 'col-span-2 h-[500px]' : 'h-[250px]' }}">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
                @endforeach
            </div>

            <div class="bg-white p-12 rounded-[3rem] shadow-xl border border-gray-100 sticky top-10">
                <span class="inline-block px-4 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase mb-6">{{ $modele->collection->nom }}</span>
                <h1 class="text-5xl font-black text-gray-900 mb-4 leading-tight italic">{{ $modele->nom }}</h1>
                <p class="text-3xl font-light text-indigo-600 mb-10">{{ number_format($modele->prix_base, 0, ',', ' ') }} FCFA</p>

                <div class="mb-12">
                    <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4 italic">Description du créateur</h4>
                    <p class="text-gray-500 leading-relaxed text-lg">{{ $modele->description ?? 'Aucune description disponible.' }}</p>
                </div>

                <div class="mb-12">
                    <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-6 border-b pb-2">Inventaire par Taille</h4>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($modele->options as $option)
                        @if($option->type == 'taille')
                        <div class="p-4 rounded-2xl border-2 {{ $option->pivot->stock > 0 ? 'border-indigo-100 bg-indigo-50/30' : 'border-red-100 bg-red-50 opacity-50' }} flex justify-between items-center transition-all">
                            <span class="font-black text-gray-900">{{ $option->valeur }}</span>
                            <span class="font-bold {{ $option->pivot->stock > 0 ? 'text-indigo-600' : 'text-red-600' }}">
                                {{ $option->pivot->stock }} <small class="text-[10px] uppercase">en stock</small>
                            </span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('styliste.modeles.edit', $modele->id) }}" class="flex-1 bg-black text-white text-center py-5 rounded-2xl font-black hover:bg-indigo-600 transition-all shadow-xl">Modifier la pièce</a>
                    <a href="{{ route('styliste.dashboard') }}" class="px-8 py-5 border-2 border-gray-100 rounded-2xl font-black text-gray-400 hover:border-black hover:text-black transition-all">Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
