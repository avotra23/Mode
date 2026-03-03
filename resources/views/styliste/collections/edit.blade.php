@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-16 px-6">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif italic text-[#2D241E]">Modifier la Collection</h1>
            <p class="text-[10px] uppercase tracking-[0.2em] text-orange-700 font-bold mt-2">Révision de l'œuvre : {{ $collection->nom }}</p>
        </div>
        <a href="{{ route('styliste.dashboard') }}" class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-black transition border-b border-gray-200 pb-1">
            Retour
        </a>
    </div>

    <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl overflow-hidden border border-orange-50">
        <form action="{{ route('styliste.collections.update', $collection->id) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-10">
            @csrf 
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center p-6 bg-orange-50/20 rounded-2xl border border-orange-50">
                <div class="text-center md:text-left">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-3 block">Image Actuelle</label>
                    <div class="relative inline-block">
                        <img src="{{ asset('storage/' . $collection->image) }}" class="w-32 h-40 object-cover rounded-lg shadow-md ring-4 ring-white">
                    </div>
                </div>

                <div class="md:col-span-2 space-y-4" x-data="imagePreview()">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-orange-700 font-bold">Remplacer le visuel</label>
                    <div class="relative">
                        <input type="file" name="image" id="new-image" class="hidden" @change="showPreview" accept="image/*">
                        <label for="new-image" class="flex items-center justify-center w-full px-6 py-8 border-2 border-dashed border-orange-100 rounded-xl cursor-pointer hover:bg-white hover:border-orange-300 transition-all group">
                            <div class="text-center">
                                <template x-if="!imgSrc">
                                    <div class="flex items-center space-x-3">
                                        <i class="fa-solid fa-arrow-up-from-bracket text-orange-700"></i>
                                        <span class="text-xs font-medium text-gray-600 group-hover:text-black">Choisir un nouveau fichier</span>
                                    </div>
                                </template>
                                <template x-if="imgSrc">
                                    <div class="flex items-center space-x-3 text-green-600">
                                        <i class="fa-solid fa-check-circle"></i>
                                        <span class="text-xs font-bold" x-text="fileName"></span>
                                    </div>
                                </template>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="relative group">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-1 block">Titre de la collection</label>
                    <input type="text" name="nom" value="{{ $collection->nom }}" 
                        class="w-full border-0 border-b border-gray-100 focus:border-orange-700 focus:ring-0 text-xl font-serif italic py-3 transition-all" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold">Saison</label>
                        <select name="saison" class="w-full border-gray-100 rounded-none bg-gray-50/50 text-sm py-4 focus:border-orange-700 focus:ring-0">
                            @foreach(['Printemps/Été', 'Automne/Hiver', 'Croisière'] as $s)
                                <option value="{{ $s }}" {{ $collection->saison == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold">Année</label>
                        <input type="number" name="annee" value="{{ $collection->annee }}" 
                            class="w-full border-gray-100 rounded-none bg-gray-50/50 text-sm py-4 focus:border-orange-700 focus:ring-0" required>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-[#2D241E] text-white py-5 rounded-none text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-orange-700 transition-all shadow-xl shadow-gray-100">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function imagePreview() {
    return {
        imgSrc: '',
        fileName: '',
        showPreview(event) {
            if (event.target.files.length > 0) {
                this.fileName = event.target.files[0].name;
                let reader = new FileReader();
                reader.onload = (e) => { this.imgSrc = e.target.result; };
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    }
}
</script>
@endsection