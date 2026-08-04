<x-admin.layout title="Painel">
    {{-- Maintenance mode --}}
    @php $maintenance = setting('maintenance_mode') === '1'; @endphp
    <section class="mb-6 flex flex-col gap-4 border-l-2 {{ $maintenance ? 'border-amber-500 bg-amber-50' : 'border-emerald-500 bg-white' }} p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-start gap-3">
            <span class="mt-0.5 grid h-9 w-9 shrink-0 place-items-center rounded-full {{ $maintenance ? 'bg-amber-500/15 text-amber-700' : 'bg-emerald-500/15 text-emerald-700' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.3 4.3a4 4 0 0 0 5.4 5.4l3.8 3.8a2 2 0 0 1-2.8 2.8l-3.8-3.8a4 4 0 0 1-5.4-5.4l2 2 1.6-1.6z"/></svg>
            </span>
            <div>
                <p class="text-sm font-semibold">Modo de manutenção · {{ $maintenance ? 'ATIVO' : 'inativo' }}</p>
                <p class="mt-0.5 text-sm text-espresso-900/55">
                    @if($maintenance)
                        Os visitantes veem a página de manutenção. Você, autenticado, continua a ver o site normalmente.
                    @else
                        O site está visível para todos os visitantes.
                    @endif
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center gap-3">
            <a href="{{ route('admin.maintenance.edit') }}" class="text-xs font-semibold uppercase tracking-[.12em] text-copper-600 hover:text-copper-700">Personalizar</a>
            <form method="post" action="{{ route('admin.maintenance.toggle') }}">
                @csrf
                <button type="submit" class="btn {{ $maintenance ? 'btn-light' : 'btn-gold' }}">{{ $maintenance ? 'Desativar manutenção' : 'Ativar manutenção' }}</button>
            </form>
        </div>
    </section>

    {{-- KPI tiles --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach([
            ['Reservas', $totals['reservations'], route('admin.reservations.index')],
            ['Reservas novas', $totals['new'], route('admin.reservations.index')],
            ['Mensagens por ler', $totals['messages'], route('admin.messages.index')],
            ['Quartos', $totals['rooms'], route('admin.rooms.index')],
        ] as [$label, $count, $url])
            <a href="{{ $url }}" class="border border-sand-200 bg-white p-6 shadow-sm transition hover:border-copper-400">
                <p class="text-4xl font-semibold text-copper-600">{{ $count }}</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-[.14em] text-espresso-900/50">{{ $label }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1.4fr_1fr]">
        {{-- Chart --}}
        <section class="cms-card">
            <h2 class="cms-card-title mb-5">Reservas · últimos 14 dias</h2>
            <div class="mt-8 flex h-48 items-end gap-2">
                @foreach($chart as $day)
                    <div class="group flex flex-1 flex-col items-center gap-2">
                        <div class="relative flex w-full items-end justify-center" style="height: 150px;">
                            <div class="w-full bg-copper-500/80 transition group-hover:bg-copper-600" style="height: {{ round(($day['count'] / $chartMax) * 100) }}%; min-height: {{ $day['count'] > 0 ? '4px' : '0' }};"></div>
                            <span class="absolute -top-5 text-[11px] font-semibold text-espresso-900/70">{{ $day['count'] > 0 ? $day['count'] : '' }}</span>
                        </div>
                        <span class="text-[9px] text-espresso-900/40">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Recent messages --}}
        <section class="cms-card">
            <div class="flex items-center justify-between">
                <h2 class="cms-card-title mb-5">Mensagens recentes</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold uppercase tracking-[.12em] text-copper-600">Ver todas</a>
            </div>
            <div class="mt-5 divide-y divide-sand-200">
                @forelse($recentMessages as $m)
                    <a href="{{ route('admin.messages.show', $m) }}" class="block py-3">
                        <div class="flex items-center justify-between">
                            <span class="{{ $m->is_read ? 'font-medium' : 'font-semibold' }}">{{ $m->name }}</span>
                            <span class="text-xs text-espresso-900/40">{{ $m->created_at->format('d/m') }}</span>
                        </div>
                        <p class="mt-0.5 truncate text-sm text-espresso-900/55">{{ $m->body }}</p>
                    </a>
                @empty
                    <p class="py-3 text-sm text-espresso-900/50">Sem mensagens.</p>
                @endforelse
            </div>
        </section>
    </div>

    {{-- Recent reservations --}}
    <section class="mt-6 border border-sand-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-sand-200 px-6 py-4">
            <h2 class="cms-card-title mb-5">Reservas recentes</h2>
            <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold uppercase tracking-[.12em] text-copper-600">Ver todas</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-sand-200 text-xs uppercase tracking-[.12em] text-espresso-900/50">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Hóspede</th>
                        <th class="px-6 py-3 font-semibold">Quarto</th>
                        <th class="px-6 py-3 font-semibold">Estadia</th>
                        <th class="px-6 py-3 font-semibold">Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand-200">
                    @forelse($recentReservations as $r)
                        <tr class="hover:bg-sand-50">
                            <td class="px-6 py-3">{{ $r->name }}</td>
                            <td class="px-6 py-3">{{ $r->room_name }}</td>
                            <td class="px-6 py-3">{{ $r->checkin->format('d/m') }} → {{ $r->checkout->format('d/m') }}</td>
                            <td class="px-6 py-3 text-espresso-900/50">{{ $r->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-espresso-900/50">Ainda não há reservas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-admin.layout>
