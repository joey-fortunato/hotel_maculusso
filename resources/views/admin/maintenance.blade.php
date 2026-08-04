<x-admin.layout title="Manutenção" subtitle="Página mostrada aos visitantes quando o site está indisponível">
    <form method="post" action="{{ route('admin.maintenance.update') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf @method('put')

        {{-- On/off switch --}}
        <section x-data="{ on: {{ $active ? 'true' : 'false' }} }" class="cms-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold">Modo de manutenção</p>
                    <p class="mt-0.5 text-sm text-espresso-900/55" x-text="on ? 'O site está oculto para os visitantes. Você continua a vê-lo normalmente.' : 'O site está visível para todos os visitantes.'"></p>
                </div>
                <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                    <input type="checkbox" name="is_active" value="1" x-model="on" class="peer sr-only">
                    <span class="block h-7 w-12 rounded-full bg-sand-300 transition-colors peer-checked:bg-amber-500 peer-focus-visible:ring-2 peer-focus-visible:ring-copper-400/40"></span>
                    <span class="pointer-events-none absolute left-1 h-5 w-5 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
                </label>
            </div>
        </section>

        {{-- Content --}}
        <section class="cms-card">
            <h2 class="cms-card-title mb-5">Conteúdo da página</h2>
            <div class="grid gap-5">
                @foreach($fields as $key => [$label, $type])
                    <div>
                        <label class="cms-label">{{ $label }}</label>
                        @if($type === 'image')
                            <div class="flex flex-wrap items-start gap-4">
                                @php $img = \App\Models\Setting::raw($key) ?: setting('hero_image'); @endphp
                                @if($img)<img src="{{ img_src($img) }}" alt="" class="h-20 w-28 shrink-0 border border-sand-200 object-cover">@endif
                                <div class="min-w-0 flex-1">
                                    <input type="text" name="{{ $key }}" value="{{ \App\Models\Setting::raw($key) }}" placeholder="URL da imagem (por defeito usa a imagem do hero)" class="cms-input">
                                    <input type="file" name="file_{{ $key }}" accept="image/*" class="mt-2 cms-file">
                                </div>
                            </div>
                        @else
                            <div class="grid gap-3 sm:grid-cols-2">
                                <x-admin.lang-field flag="PT" :name="$key" :type="$type" :value="\App\Models\Setting::raw($key) ?: ($defaults[$key] ?? '')" />
                                <x-admin.lang-field flag="EN" :name="'en_'.$key" :type="$type" :value="\App\Models\Setting::rawEn($key)" />
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <p class="mt-5 border-t border-sand-100 pt-4 text-xs text-espresso-900/45">Os contactos (telefone e email) mostrados na página vêm das definições em <strong>Páginas → Geral</strong>.</p>
        </section>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-gold">Guardar</button>
        </div>
    </form>
</x-admin.layout>
