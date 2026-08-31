<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class AuditController extends Controller
{
    /** Action codes offered in the filter dropdown. */
    private const ACTIONS = [
        'login' => 'Início de sessão',
        'logout' => 'Fim de sessão',
        'login_failed' => 'Login falhado',
        'created' => 'Criação',
        'updated' => 'Edição',
        'deleted' => 'Eliminação',
        'reservation_submitted' => 'Nova reserva',
        'message_received' => 'Nova mensagem',
        'settings_updated' => 'Definições',
        'user_created' => 'Utilizador criado',
        'user_updated' => 'Utilizador editado',
        'user_deleted' => 'Utilizador removido',
    ];

    public function index(Request $request): View
    {
        $logs = $this->query($request)->paginate(30)->withQueryString();

        return view('admin.audit.index', [
            'logs' => $logs,
            'actions' => self::ACTIONS,
            'users' => User::orderBy('name')->get(['id', 'name']),
            'filters' => $request->only(['action', 'user', 'from', 'to', 'q']),
            'total' => AuditLog::count(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'auditoria-'.now()->format('Y-m-d_His').'.csv';

        return response()->streamDownload(function () use ($request) {
            $out = fopen('php://output', 'w');
            fprintf($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($out, ['Data/Hora', 'Ator', 'Ação', 'Alvo', 'Descrição', 'IP']);

            $this->query($request)->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $log) {
                    fputcsv($out, [
                        $log->created_at->format('Y-m-d H:i:s'),
                        $log->actor_name,
                        self::ACTIONS[$log->action] ?? $log->action,
                        trim(($log->subject_type ?? '').' '.($log->subject_id ? '#'.$log->subject_id : '')),
                        $log->description,
                        $log->ip_address,
                    ]);
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** Shared, filtered query for both listing and export. */
    private function query(Request $request)
    {
        return AuditLog::query()
            ->with('user')
            ->when($request->filled('action'), fn ($q) => $q->where('action', $request->input('action')))
            ->when($request->filled('user'), fn ($q) => $q->where('user_id', $request->input('user')))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date('to')))
            ->when($request->filled('q'), fn ($q) => $q->where(function ($sub) use ($request) {
                $term = '%'.$request->input('q').'%';
                $sub->where('description', 'like', $term)
                    ->orWhere('actor_name', 'like', $term)
                    ->orWhere('ip_address', 'like', $term);
            }))
            ->latest();
    }
}
