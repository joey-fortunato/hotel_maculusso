<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Immutable record of an activity on the platform.
 * Written by AuditObserver (model events) and auth event listeners.
 */
class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'actor_name', 'action', 'subject_type', 'subject_id',
        'description', 'properties', 'ip_address', 'user_agent',
    ];

    protected function casts(): array
    {
        return ['properties' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Capture the current actor + request context and persist one entry.
     */
    public static function record(
        string $action,
        ?Model $subject = null,
        ?string $description = null,
        array $properties = [],
        ?string $actorName = null,
    ): void {
        $user = Auth::user();
        $request = request();

        static::create([
            'user_id' => $user?->getKey(),
            'actor_name' => $actorName ?? $user?->name ?? 'Visitante',
            'action' => $action,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description ? mb_substr($description, 0, 500) : null,
            'properties' => $properties !== [] ? $properties : null,
            'ip_address' => $request?->ip(),
            'user_agent' => mb_substr((string) $request?->userAgent(), 0, 255) ?: null,
        ]);
    }

    /** Human label for an action code. */
    public function actionLabel(): string
    {
        return [
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
        ][$this->action] ?? ucfirst($this->action);
    }
}
