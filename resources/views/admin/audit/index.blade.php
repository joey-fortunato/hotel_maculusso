<x-admin.layout title="Auditoria" subtitle="Registo de atividade da plataforma">
    @php
        $badge = [
            'login' => 'bg-emerald-500/10 text-emerald-700 ring-emerald-500/20',
            'logout' => 'bg-espresso-900/5 text-espresso-900/60 ring-espresso-900/10',
            'login_failed' => 'bg-red-500/10 text-red-700 ring-red-500/20',
            'created' => 'bg-copper-500/10 text-copper-700 ring-copper-500/20',
            'updated' => 'bg-amber-500/10 text-amber-700 ring-amber-500/20',
            'deleted' => 'bg-red-500/10 text-red-700 ring-red-500/20',
            'reservation_submitted' => 'bg-copper-500/10 text-copper-700 ring-copper-500/20',
            'message_received' => 'bg-sky-500/10 text-sky-700 ring-sky-500/20',
            'settings_updated' => 'bg-amber-500/10 text-amber-700 ring-amber-500/20',
        ];
        $pill = fn ($a) => $badge[$a] ?? ($str = 'bg-espresso-900/5 text-espresso-900/60 ring-espresso-900/10');
    @endphp

    {{-- Toolbar --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-espresso-900/60"><span class="font-semibold text-espresso-900">{{ number_format($total, 0, ',', ' ') }}</span> registos no total</p>
        <a href="{{ route('admin.audit.export', $filters) }}" class="btn btn-light inline-flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16"/></svg>
            Exportar CSV
        </a>
    </div>

    {{-- Filters --}}
    <form method="get" class="cms-card mb-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <label class="cms-label">Pesquisar</label>
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Descrição, ator ou IP" class="cms-input">
            </div>
            <div>
                <label class="cms-label">Ação</label>
                <select name="action" class="cms-input">
                    <option value="">Todas</option>
                    @foreach($actions as $code => $label)
                        <option value="{{ $code }}" @selected(($filters['action'] ?? '') === $code)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="cms-label">Utilizador</label>
                <select name="user" class="cms-input">
                    <option value="">Todos</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" @selected((string)($filters['user'] ?? '') === (string)$u->id)>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="cms-label">De</label>
                    <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="cms-input">
                </div>
                <div>
                    <label class="cms-label">Até</label>
                    <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="cms-input">
                </div>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-3">
            <button type="submit" class="btn btn-gold">Filtrar</button>
            @if(array_filter($filters))
                <a href="{{ route('admin.audit.index') }}" class="text-sm font-medium text-espresso-900/50 hover:text-copper-600">Limpar filtros</a>
            @endif
        </div>
    </form>

    {{-- Log table --}}
    <div class="overflow-x-auto border border-sand-200 bg-white shadow-sm">
        <table class="w-full min-w-[820px] text-left text-sm">
            <thead class="border-b border-sand-200 bg-sand-50 text-[11px] font-semibold uppercase tracking-[.12em] text-espresso-900/45">
                <tr>
                    <th class="px-5 py-3">Data / Hora</th>
                    <th class="px-5 py-3">Ator</th>
                    <th class="px-5 py-3">Ação</th>
                    <th class="px-5 py-3">Detalhe</th>
                    <th class="px-5 py-3">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-200">
                @forelse($logs as $log)
                    <tr class="align-top transition hover:bg-sand-50">
                        <td class="whitespace-nowrap px-5 py-4 text-xs text-espresso-900/60">
                            {{ $log->created_at->format('d/m/Y') }}<br>
                            <span class="text-espresso-900/40">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-medium">{{ $log->actor_name ?? 'Visitante' }}</span>
                            @unless($log->user_id)<span class="ml-1 text-[11px] text-espresso-900/40">(público)</span>@endunless
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center whitespace-nowrap rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 {{ $pill($log->action) }}">
                                {{ $log->actionLabel() }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-espresso-900/80">{{ $log->description }}</p>
                            @if($log->subject_type)
                                <p class="mt-0.5 text-[11px] text-espresso-900/40">{{ $log->subject_type }}{{ $log->subject_id ? ' #'.$log->subject_id : '' }}</p>
                            @endif
                            @if(!empty($log->properties))
                                <details class="mt-1.5">
                                    <summary class="cursor-pointer text-[11px] font-semibold uppercase tracking-[.1em] text-copper-600 hover:text-copper-700">Ver alterações</summary>
                                    <div class="mt-2 space-y-1 border-l-2 border-sand-200 pl-3 text-xs">
                                        @foreach($log->properties as $field => $change)
                                            <div>
                                                <span class="font-medium text-espresso-900/70">{{ $field }}:</span>
                                                @if(is_array($change))
                                                    <span class="text-espresso-900/40 line-through">{{ $change['de'] ?? '—' }}</span>
                                                    <span class="text-espresso-900/30">→</span>
                                                    <span class="text-espresso-900/80">{{ $change['para'] ?? '—' }}</span>
                                                @else
                                                    <span class="text-espresso-900/70">{{ is_scalar($change) ? $change : json_encode($change) }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-5 py-4 text-xs text-espresso-900/45">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-16 text-center text-espresso-900/50">Nenhuma atividade registada para estes filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div class="mt-6">{{ $logs->links() }}</div>
    @endif
</x-admin.layout>
