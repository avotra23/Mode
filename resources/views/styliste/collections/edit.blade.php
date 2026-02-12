@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-16 px-6">
    <div class="bg-white border border-gray-100 shadow-sm rounded-xl overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
            <h1 class="text-xl font-medium text-gray-800 italic">Édition • {{ $collection->nom }}</h1>
        </div>

        <form action="{{ route('styliste.collections.update', $collection->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf @method('PUT')

            <div class="flex items-center gap-6 p-4 rounded-xl border border-gray-100">
                <img src="{{ asset('storage/' . $collection->image) }}" class="w-20 h-24 object-cover rounded shadow-sm">
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-indigo-500 tracking-wider">Nouvelle Image</label>
                    <input type="file" name="image" class="text-xs text-gray-400 block file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Titre de la collection</label>
                    <input type="text" name="nom" value="{{ $collection->nom }}" class="w-full border-gray-200 rounded-lg text-sm py-3 focus:ring-0" required>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Saison</label>
                        <select name="saison" class="w-full border-gray-200 rounded-lg text-sm py-3">
                            @foreach(['Printemps/Été', 'Automne/Hiver', 'Croisière'] as $s)
                                <option value="{{ $s }}" {{ $collection->saison == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Année</label>
                        <input type="number" name="annee" value="{{ $collection->annee }}" class="w-full border-gray-200 rounded-lg text-sm py-3" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-lg text-xs font-semibold uppercase tracking-widest hover:bg-black transition-all">
                Mettre à jour
            </button>
        </form>
    </div>
</div>
@endsection
