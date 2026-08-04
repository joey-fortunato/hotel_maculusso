@php
    $editing = $room->exists;
    $input = 'cms-input';
    $lbl = 'cms-label';
    $card = 'cms-card';
@endphp
<x-admin.layout :title="$editing ? 'Editar quarto' : 'Novo quarto'">
    <a href="{{ route('admin.rooms.index') }}" class="link-arrow"><span aria-hidden="true">&larr;</span> Voltar aos quartos</a>

    @if($errors->any())
        <div class="mt-6 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="post" action="{{ $editing ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($editing) @method('put') @endif

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Main column --}}
            <div class="space-y-6 lg:col-span-2">
                <section class="{{ $card }}">
                    <h2 class="cms-card-title mb-5">Informação</h2>
                    <div class="grid gap-5">
                        <div>
                            <label class="{{ $lbl }}">Nome</label>
                            <input name="name" value="{{ old('name', $room->name) }}" class="{{ $input }}" required>
                            <input name="name_en" value="{{ old('name_en', $room->name_en) }}" class="{{ $input }} mt-2" placeholder="English name">
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Sobre-título</label>
                            <input name="tagline" value="{{ old('tagline', $room->tagline) }}" class="{{ $input }}" placeholder="ex: Conforto para quem trabalha">
                            <input name="tagline_en" value="{{ old('tagline_en', $room->tagline_en) }}" class="{{ $input }} mt-2" placeholder="English tagline">
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Descrição</label>
                            <textarea name="description" rows="3" class="{{ $input }}">{{ old('description', $room->description) }}</textarea>
                            <textarea name="description_en" rows="3" class="{{ $input }} mt-2" placeholder="English description">{{ old('description_en', $room->description_en) }}</textarea>
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Comodidades <span class="font-normal normal-case text-espresso-900/40">— uma por linha</span></label>
                            <textarea name="amenities" rows="5" class="{{ $input }}">{{ old('amenities', is_array($room->amenities) ? implode("\n", $room->amenities) : '') }}</textarea>
                            <textarea name="amenities_en" rows="5" class="{{ $input }} mt-2" placeholder="Amenities in English — one per line">{{ old('amenities_en', is_array($room->amenities_en) ? implode("\n", $room->amenities_en) : '') }}</textarea>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-espresso-900/40"><span class="font-semibold text-copper-600">EN</span> — o segundo campo de cada par é a tradução em inglês (opcional; se vazio, usa o português).</p>
                </section>

                {{-- Gallery --}}
                <section x-data="{ gallery: {{ Illuminate\Support\Js::from(old('gallery', $room->gallery ?? [])) }} }" class="{{ $card }}">
                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="cms-card-title mb-5">Galeria de fotos</h2>
                        <button type="button" @click="gallery.push('')" class="text-xs font-semibold uppercase tracking-[.12em] text-copper-600 hover:text-copper-700">+ Adicionar URL</button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(g, i) in gallery" :key="i">
                            <div class="flex items-center gap-3">
                                <template x-if="g"><img :src="g.startsWith('http') ? g : '/' + g.replace(/^\//,'')" alt="" class="h-11 w-16 shrink-0 border border-sand-200 object-cover"></template>
                                <input :name="'gallery[' + i + ']'" x-model="gallery[i]" placeholder="URL da imagem" class="{{ $input }}">
                                <button type="button" @click="gallery.splice(i, 1)" class="shrink-0 text-espresso-900/40 hover:text-red-600">&times;</button>
                            </div>
                        </template>
                        <p x-show="gallery.length === 0" class="text-sm text-espresso-900/45">Sem fotos na galeria. Adicione URLs ou carregue ficheiros abaixo.</p>
                    </div>
                    <div class="mt-5 border-t border-sand-200 pt-5">
                        <label class="{{ $lbl }}">Carregar fotos (adiciona à galeria)</label>
                        <input type="file" name="gallery_files[]" accept="image/*" multiple class="cms-file">
                    </div>
                </section>
            </div>

            {{-- Side column --}}
            <div class="space-y-6">
                <section class="{{ $card }}">
                    <h2 class="cms-card-title mb-5">Tarifas & lotação</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="{{ $lbl }}">Individual (Kz)</label>
                            <input type="number" name="price" value="{{ old('price', $room->price) }}" class="{{ $input }}" required>
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Duplo (Kz)</label>
                            <input type="number" name="price_double" value="{{ old('price_double', $room->price_double) }}" class="{{ $input }}" required>
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Máx. hóspedes</label>
                            <input type="number" name="max_guests" value="{{ old('max_guests', $room->max_guests) }}" class="{{ $input }}" required>
                        </div>
                        <div>
                            <label class="{{ $lbl }}">Área</label>
                            <input name="size" value="{{ old('size', $room->size) }}" class="{{ $input }}" placeholder="30 m²">
                        </div>
                        <div class="col-span-2">
                            <label class="{{ $lbl }}">Cama</label>
                            <input name="bed" value="{{ old('bed', $room->bed) }}" class="{{ $input }}" placeholder="Cama queen">
                            <input name="bed_en" value="{{ old('bed_en', $room->bed_en) }}" class="{{ $input }} mt-2" placeholder="Queen bed">
                        </div>
                    </div>
                </section>

                <section class="{{ $card }}">
                    <h2 class="cms-card-title mb-5">Imagem principal</h2>
                    @if($room->image)<img src="{{ img_src($room->image) }}" alt="" class="mb-3 h-32 w-full border border-sand-200 object-cover">@endif
                    <input name="image_url" value="{{ old('image_url', $room->image) }}" class="{{ $input }}" placeholder="URL da imagem">
                    <input type="file" name="image_file" accept="image/*" class="mt-2 cms-file">
                </section>

                <section class="{{ $card }}">
                    <label class="flex items-center gap-2.5 text-sm">
                        <input type="checkbox" name="is_published" value="1" class="accent-copper-500" {{ old('is_published', $room->is_published) ? 'checked' : '' }}>
                        Publicado (visível no site)
                    </label>
                </section>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-gold">{{ $editing ? 'Guardar alterações' : 'Criar quarto' }}</button>
        </div>
    </form>
</x-admin.layout>
