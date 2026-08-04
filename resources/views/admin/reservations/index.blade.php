@php
    $statusStyles = [
        'pending' => 'cms-pill-pending',
        'confirmed' => 'cms-pill-confirmed',
        'cancelled' => 'cms-pill-cancelled',
    ];
    $statusLabels = ['pending' => 'Pendente', 'confirmed' => 'Confirmada', 'cancelled' => 'Cancelada'];
@endphp
<x-admin.layout title="Reservas" subtitle="Pedidos de reserva recebidos pelo site">
    <p class="mb-6 text-sm text-espresso-900/55">{{ $reservations->count() }} pedidos · {{ $reservations->where('status', 'pending')->count() }} pendentes</p>

    <div class="overflow-x-auto border border-sand-200 bg-white shadow-sm">
        <table class="w-full min-w-[820px] text-left text-sm">
            <thead class="border-b border-sand-200 text-xs uppercase tracking-[.12em] text-espresso-900/50">
                <tr>
                    <th class="px-5 py-4 font-semibold">Hóspede</th>
                    <th class="px-5 py-4 font-semibold">Quarto</th>
                    <th class="px-5 py-4 font-semibold">Estadia</th>
                    <th class="px-5 py-4 font-semibold">Contacto</th>
                    <th class="px-5 py-4 font-semibold">Estado</th>
                    <th class="px-5 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-200">
                @forelse($reservations as $r)
                    <tr class="align-top transition hover:bg-sand-50">
                        <td class="px-5 py-4">
                            <p class="font-medium">{{ $r->name }}</p>
                            <p class="text-xs text-espresso-900/50">{{ $r->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-4">{{ $r->room_name }}<br><span class="text-xs text-espresso-900/50">{{ $r->guests }} hóspede(s)</span></td>
                        <td class="px-5 py-4">{{ $r->checkin->format('d/m/Y') }} → {{ $r->checkout->format('d/m/Y') }}<br><span class="text-xs text-espresso-900/50">{{ $r->nights }} noite(s)</span></td>
                        <td class="px-5 py-4">
                            <a href="mailto:{{ $r->email }}" class="text-copper-600 hover:underline">{{ $r->email }}</a><br>
                            <a href="tel:{{ $r->phone }}" class="text-xs text-espresso-900/60">{{ $r->phone }}</a>
                        </td>
                        <td class="px-5 py-4">
                            <form method="post" action="{{ route('admin.reservations.update', $r) }}">
                                @csrf @method('patch')
                                <select name="status" onchange="this.form.submit()" class="border border-sand-300 bg-white px-2.5 py-1.5 text-xs font-semibold uppercase tracking-wide {{ $statusStyles[$r->status] ?? '' }}">
                                    @foreach($statusLabels as $val => $lab)
                                        <option value="{{ $val }}" @selected($r->status === $val)>{{ $lab }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <form method="post" action="{{ route('admin.reservations.destroy', $r) }}" onsubmit="return confirm('Eliminar esta reserva?')">
                                @csrf @method('delete')
                                <button class="text-xs font-semibold uppercase tracking-[.12em] text-espresso-900/40 hover:text-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-12 text-center text-espresso-900/50">Ainda não há reservas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin.layout>
