<x-admin.layout title="Quartos">
    <div class="mb-6 flex items-center justify-between">
        <p class="text-espresso-900/60">{{ $rooms->count() }} quartos</p>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-gold">Novo quarto</a>
    </div>

    <div class="overflow-x-auto border border-sand-200 bg-white shadow-sm">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="border-b border-sand-200 text-xs uppercase tracking-[.14em] text-espresso-900/50">
                <tr>
                    <th class="px-5 py-4 font-semibold">Quarto</th>
                    <th class="px-5 py-4 font-semibold">Individual</th>
                    <th class="px-5 py-4 font-semibold">Duplo</th>
                    <th class="px-5 py-4 font-semibold">Máx.</th>
                    <th class="px-5 py-4 font-semibold">Estado</th>
                    <th class="px-5 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-200">
                @forelse($rooms as $room)
                    <tr class="transition hover:bg-sand-50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($room->image)
                                    <img src="{{ img_src($room->image) }}" alt="" class="h-12 w-16 shrink-0 object-cover">
                                @endif
                                <div>
                                    <p class="font-display text-lg leading-tight">{{ $room->name }}</p>
                                    <p class="text-xs text-espresso-900/50">{{ $room->detail }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">{{ number_format($room->price, 0, ',', ' ') }} Kz</td>
                        <td class="px-5 py-4">{{ number_format($room->price_double, 0, ',', ' ') }} Kz</td>
                        <td class="px-5 py-4">{{ $room->max_guests }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-block px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $room->is_published ? 'bg-copper-500/15 text-copper-700' : 'bg-espresso-900/10 text-espresso-900/50' }}">{{ $room->is_published ? 'Publicado' : 'Oculto' }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="text-xs font-semibold uppercase tracking-[.14em] text-copper-600 hover:text-copper-700">Editar</a>
                                <form method="post" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Eliminar este quarto?')">
                                    @csrf @method('delete')
                                    <button class="text-xs font-semibold uppercase tracking-[.14em] text-espresso-900/40 hover:text-red-600">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-espresso-900/50">Ainda não há quartos. <a href="{{ route('admin.rooms.create') }}" class="text-copper-600 underline">Criar o primeiro</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.layout>
