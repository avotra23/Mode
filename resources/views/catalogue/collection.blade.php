@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-16">
    <div class="mb-16">
        <span class="text-orange-700 font-bold uppercase tracking-widest text-xs">Archives & Nouveautés</span>
        <h1 class="text-5xl font-serif mt-2 italic">Nos Collections</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($collections as $collection)
        <a href="#" class="group relative overflow-hidden bg-gray-900 aspect-[16/9]">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200"
                 class="object-cover w-full h-full opacity-60 group-hover:scale-110 transition-transform duration-700">

            <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-8">
                <span class="text-xs uppercase tracking-[0.3em] mb-2">{{ $collection->annee }}</span>
                <h2 class="text-4xl font-serif italic tracking-wider">{{ $collection->nom }}</h2>
                <div class="mt-6 px-6 py-2 border border-white text-xs uppercase font-bold tracking-widest group-hover:bg-white group-hover:text-black transition-colors">
                    Découvrir l'univers
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
