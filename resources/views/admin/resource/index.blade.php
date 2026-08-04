@php
    $imageField = collect($fields)->firstWhere('type', 'image')['name'] ?? null;
    $hasPublished = collect($fields)->contains('name', 'is_published');
@endphp
<x-admin.layout :title="$labels[1]">
    <div class="mb-6 flex items-center justify-between">
        <p class="text-espresso-900/60">{{ $records->count() }} {{ Str::lower($labels[1]) }}</p>
        <a href="{{ route('admin.'.$route.'.create') }}" class="btn btn-gold">Novo</a>
    </div>

    <div class="overflow-x-auto border border-sand-200 bg-white shadow-sm">
        <table class="w-full min-w-[560px] text-left text-sm">
            <thead class="border-b border-sand-200 text-xs uppercase tracking-[.14em] text-espresso-900/50">
                <tr>
                    <th class="px-5 py-4 font-semibold">{{ $labels[0] }}</th>
                    <th class="px-5 py-4 font-semibold">Ordem</th>
                    @if($hasPublished)<th class="px-5 py-4 font-semibold">Estado</th>@endif
                    <th class="px-5 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-200">
                @forelse($records as $record)
                    <tr class="transition hover:bg-sand-50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($imageField && $record->{$imageField})
                                    <img src="{{ img_src($record->{$imageField}) }}" alt="" class="h-11 w-16 shrink-0 object-cover">
                                @endif
                                <span class="font-medium">{{ Str::limit($record->{$titleField} ?: '(sem título)', 60) }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-espresso-900/60">{{ $record->sort }}</td>
                        @if($hasPublished)
                            <td class="px-5 py-4">
                                <span class="inline-block px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $record->is_published ? 'bg-copper-500/15 text-copper-700' : 'bg-espresso-900/10 text-espresso-900/50' }}">{{ $record->is_published ? 'Publicado' : 'Oculto' }}</span>
                            </td>
                        @endif
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.'.$route.'.edit', $record) }}" class="text-xs font-semibold uppercase tracking-[.14em] text-copper-600 hover:text-copper-700">Editar</a>
                                <form method="post" action="{{ route('admin.'.$route.'.destroy', $record) }}" onsubmit="return confirm('Eliminar?')">
                                    @csrf @method('delete')
                                    <button class="text-xs font-semibold uppercase tracking-[.14em] text-espresso-900/40 hover:text-red-600">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-espresso-900/50">Ainda não há registos. <a href="{{ route('admin.'.$route.'.create') }}" class="text-copper-600 underline">Criar o primeiro</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.layout>
