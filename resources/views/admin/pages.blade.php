@php
    $input = 'cms-input';
    $lbl = 'cms-label';
    $legalTabs = ['privacy' => 'Privacidade', 'terms' => 'Termos'];
@endphp
<x-admin.layout title="Páginas">
    <div x-data="{ tab: 'inicio' }">
        {{-- Tab bar --}}
        <div class="mb-6 flex flex-wrap gap-1 border-b border-sand-200">
            @foreach($tabs as $key => $tab)
                <button type="button" @click="tab = '{{ $key }}'"
                        class="border-b-2 px-4 py-3 text-sm font-medium transition"
                        :class="tab === '{{ $key }}' ? 'border-copper-500 text-copper-700' : 'border-transparent text-espresso-900/55 hover:text-espresso-900'">{{ $tab['label'] }}</button>
            @endforeach
            @foreach($legalTabs as $key => $label)
                <button type="button" @click="tab = '{{ $key }}'"
                        class="border-b-2 px-4 py-3 text-sm font-medium transition"
                        :class="tab === '{{ $key }}' ? 'border-copper-500 text-copper-700' : 'border-transparent text-espresso-900/55 hover:text-espresso-900'">{{ $label }}</button>
            @endforeach
        </div>

        <form method="post" action="{{ route('admin.pages.update') }}" enctype="multipart/form-data">
            @csrf @method('put')

            {{-- Content tabs (settings) --}}
            @foreach($tabs as $key => $tab)
                <div x-show="tab === '{{ $key }}'" x-cloak class="space-y-6">
                    @foreach($tab['blocks'] as $blockTitle => $fields)
                        <section class="cms-card">
                            <h2 class="cms-card-title mb-5">{{ $blockTitle }}</h2>
                            <div class="grid gap-5">
                                @foreach($fields as $fkey => [$label, $type])
                                    <div>
                                        <label class="{{ $lbl }}">{{ $label }}</label>
                                        @if($type === 'image')
                                            <div class="flex flex-wrap items-start gap-4">
                                                @if(\App\Models\Setting::raw($fkey))<img src="{{ img_src(\App\Models\Setting::raw($fkey)) }}" alt="" class="h-20 w-28 shrink-0 border border-sand-200 object-cover">@endif
                                                <div class="min-w-0 flex-1">
                                                    <input type="text" name="{{ $fkey }}" value="{{ \App\Models\Setting::raw($fkey) }}" placeholder="URL da imagem" class="{{ $input }}">
                                                    <input type="file" name="file_{{ $fkey }}" accept="image/*" class="mt-2 cms-file">
                                                </div>
                                            </div>
                                        @else
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <x-admin.lang-field flag="PT" :name="$fkey" :type="$type" :value="\App\Models\Setting::raw($fkey)" />
                                                <x-admin.lang-field flag="EN" :name="'en_'.$fkey" :type="$type" :value="\App\Models\Setting::rawEn($fkey)" />
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            @endforeach

            {{-- Legal tabs (Page model) --}}
            @foreach($legalTabs as $key => $label)
                @php $page = $legal[$key] ?? null; @endphp
                <div x-show="tab === '{{ $key }}'" x-cloak class="space-y-6">
                    <section class="cms-card">
                        <h2 class="cms-card-title mb-5">{{ $label }}</h2>
                        <div class="grid gap-5">
                            <div>
                                <label class="{{ $lbl }}">Título</label>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <x-admin.lang-field flag="PT" :name="'legal['.$key.'][title]'" type="text" :value="$page?->getRawOriginal('title')" />
                                    <x-admin.lang-field flag="EN" :name="'legal['.$key.'][title_en]'" type="text" :value="$page?->getRawOriginal('title_en')" />
                                </div>
                            </div>
                            <div>
                                <label class="{{ $lbl }}">Introdução</label>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <x-admin.lang-field flag="PT" :name="'legal['.$key.'][intro]'" type="textarea" :value="$page?->getRawOriginal('intro')" />
                                    <x-admin.lang-field flag="EN" :name="'legal['.$key.'][intro_en]'" type="textarea" :value="$page?->getRawOriginal('intro_en')" />
                                </div>
                            </div>
                        </div>
                    </section>

                    <section x-data="{ sections: {{ Illuminate\Support\Js::from(collect($page?->sections ?: [])->map(fn($s, $idx) => ['title' => $s['title'] ?? '', 'body' => $s['body'] ?? '', 'title_en' => ($page?->sections_en[$idx]['title'] ?? ''), 'body_en' => ($page?->sections_en[$idx]['body'] ?? '')])->all() ?: [['title' => '', 'body' => '', 'title_en' => '', 'body_en' => '']]) }} }" class="cms-card">
                        <div class="mb-5 flex items-center justify-between">
                            <h2 class="cms-card-title mb-5">Secções</h2>
                            <button type="button" @click="sections.push({ title: '', body: '', title_en: '', body_en: '' })" class="text-xs font-semibold uppercase tracking-[.12em] text-copper-600 hover:text-copper-700">+ Adicionar</button>
                        </div>
                        <div class="space-y-4">
                            <template x-for="(s, i) in sections" :key="i">
                                <div class="border border-sand-200 p-4">
                                    <div class="mb-3 flex items-center justify-between">
                                        <span class="text-[10px] font-semibold uppercase tracking-[.16em] text-espresso-900/40" x-text="'Secção ' + (i + 1)"></span>
                                        <button type="button" @click="sections.splice(i, 1)" class="text-xs text-espresso-900/40 hover:text-red-600">Remover</button>
                                    </div>
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <div>
                                            <span class="mb-1 inline-block rounded-sm bg-espresso-900/5 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-[.1em] text-espresso-900/45">PT</span>
                                            <input :name="'legal[{{ $key }}][section_title][' + i + ']'" x-model="s.title" placeholder="Título da secção" class="cms-input">
                                            <textarea :name="'legal[{{ $key }}][section_body][' + i + ']'" x-model="s.body" rows="3" placeholder="Texto" class="cms-input mt-2"></textarea>
                                        </div>
                                        <div>
                                            <span class="mb-1 inline-block rounded-sm bg-espresso-900/5 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-[.1em] text-copper-600">EN</span>
                                            <input :name="'legal[{{ $key }}][section_title_en][' + i + ']'" x-model="s.title_en" placeholder="Section title" class="cms-input">
                                            <textarea :name="'legal[{{ $key }}][section_body_en][' + i + ']'" x-model="s.body_en" rows="3" placeholder="Text" class="cms-input mt-2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </section>
                </div>
            @endforeach

            <div class="sticky bottom-0 mt-6 flex justify-end border-t border-sand-200 bg-sand-100/90 py-4 backdrop-blur">
                <button type="submit" class="btn btn-gold">Guardar alterações</button>
            </div>
        </form>
    </div>
</x-admin.layout>
