<x-admin.layout title="Mensagens">
    <p class="mb-6 text-espresso-900/60">{{ $messages->count() }} mensagens · {{ $messages->where('is_read', false)->count() }} por ler</p>

    <div class="overflow-hidden border border-sand-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <tbody class="divide-y divide-sand-200">
                @forelse($messages as $m)
                    <tr class="transition hover:bg-sand-50 {{ $m->is_read ? '' : 'bg-copper-500/[0.04]' }}">
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.messages.show', $m) }}" class="block">
                                <div class="flex items-center gap-2">
                                    @unless($m->is_read)<span class="h-2 w-2 shrink-0 rounded-full bg-copper-500"></span>@endunless
                                    <span class="{{ $m->is_read ? 'font-medium' : 'font-semibold' }}">{{ $m->name }}</span>
                                    <span class="text-xs text-espresso-900/45">{{ $m->email }}</span>
                                </div>
                                <p class="mt-1 truncate text-espresso-900/60">{{ $m->body }}</p>
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-right text-xs text-espresso-900/45">
                            {{ $m->created_at->format('d/m/Y H:i') }}
                            <form method="post" action="{{ route('admin.messages.destroy', $m) }}" onsubmit="return confirm('Eliminar?')" class="mt-2">
                                @csrf @method('delete')
                                <button class="font-semibold uppercase tracking-[.12em] text-espresso-900/40 hover:text-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-12 text-center text-espresso-900/50">Ainda não há mensagens.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.layout>
