@php
    $editing = $record->exists;
    $input = 'cms-input';
    $lbl = 'cms-label';
@endphp
<x-admin.layout :title="($editing ? 'Editar ' : 'Novo ').Str::lower($labels[0])">
    <a href="{{ route('admin.'.$route.'.index') }}" class="link-arrow"><span aria-hidden="true">&larr;</span> Voltar</a>

    @if($errors->any())
        <div class="mt-6 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="post" action="{{ $editing ? route('admin.'.$route.'.update', $record) : route('admin.'.$route.'.store') }}" enctype="multipart/form-data" class="mt-6 max-w-3xl">
        @csrf
        @if($editing) @method('put') @endif

        <div class="grid gap-6 cms-card">
            @foreach($fields as $f)
                @php $name = $f['name']; $value = old($name, $record->{$name}); $translatable = ! empty($f['translatable']); @endphp
                @if($f['type'] === 'checkbox')
                    <label class="flex items-center gap-2.5 border-t border-sand-100 pt-5 text-sm">
                        <input type="checkbox" name="{{ $name }}" value="1" class="accent-copper-500" {{ old($name, $record->{$name}) ? 'checked' : '' }}>
                        {{ $f['label'] }}
                    </label>
                @else
                    <div>
                        <label class="{{ $lbl }}">{{ $f['label'] }}</label>
                        @if($f['type'] === 'image')
                            <div class="flex flex-wrap items-start gap-4">
                                @if($record->{$name})
                                    <img src="{{ img_src($record->{$name}) }}" alt="" class="h-20 w-28 shrink-0 border border-sand-200 object-cover">
                                @endif
                                <div class="min-w-0 flex-1">
                                    <input type="text" name="{{ $name }}" value="{{ $value }}" placeholder="URL da imagem" class="{{ $input }}">
                                    <input type="file" name="{{ $name }}_file" accept="image/*" class="mt-2 cms-file">
                                </div>
                            </div>
                        @elseif($translatable)
                            <div class="grid gap-3 sm:grid-cols-2">
                                <x-admin.lang-field flag="PT" :name="$name" :type="$f['type']" :value="$value" />
                                <x-admin.lang-field flag="EN" :name="$name.'_en'" :type="$f['type']" :value="old($name.'_en', $record->{$name.'_en'})" />
                            </div>
                        @elseif($f['type'] === 'textarea')
                            <textarea name="{{ $name }}" rows="4" class="{{ $input }}">{{ $value }}</textarea>
                        @else
                            <input type="{{ $f['type'] === 'number' ? 'number' : 'text' }}" name="{{ $name }}" value="{{ $value }}" class="{{ $input }}">
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.'.$route.'.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-gold">{{ $editing ? 'Guardar' : 'Criar' }}</button>
        </div>
    </form>
</x-admin.layout>
