<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Generic auditor attached to content/domain models.
 * Turns Eloquent create/update/delete events into human-readable audit entries.
 */
class AuditObserver
{
    /** Portuguese labels per model. */
    private const LABELS = [
        'Room' => 'Quarto',
        'Service' => 'Serviço',
        'Amenity' => 'Comodidade',
        'Testimonial' => 'Testemunho',
        'RestaurantItem' => 'Item do restaurante',
        'GalleryImage' => 'Imagem da galeria',
        'NavItem' => 'Item de menu',
        'Page' => 'Página',
        'Reservation' => 'Reserva',
        'Message' => 'Mensagem',
        'Setting' => 'Definição',
        'User' => 'Utilizador',
    ];

    /** Attributes never stored in the audit trail (and, if only these change, not worth an entry). */
    private const HIDDEN = ['password', 'remember_token', 'created_at', 'updated_at', 'is_read'];

    public function created(Model $model): void
    {
        $this->write('created', $model);
    }

    public function updated(Model $model): void
    {
        $changes = $this->changes($model);

        // Nothing meaningful changed (e.g. remember_token, marking a message read) — don't log.
        if ($changes === []) {
            return;
        }

        $this->write('updated', $model, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->write('deleted', $model);
    }

    private function write(string $event, Model $model, array $changes = []): void
    {
        // Skip seeders / migrations / artisan / tinker — only audit real activity.
        if (app()->runningInConsole()) {
            return;
        }

        $class = class_basename($model);
        $label = self::LABELS[$class] ?? $class;
        $title = $this->title($model);

        [$action, $verb] = $this->resolve($class, $event);

        $description = match ($action) {
            'reservation_submitted' => "Nova reserva de {$title}",
            'message_received' => "Nova mensagem de {$title}",
            'settings_updated' => "Definição '{$title}' alterada",
            default => trim("{$label} “{$title}” {$verb}"),
        };

        AuditLog::record($action, $model, $description, $changes);
    }

    /** @return array{0:string,1:string} [action code, PT verb] */
    private function resolve(string $class, string $event): array
    {
        if ($class === 'Reservation' && $event === 'created') {
            return ['reservation_submitted', 'criada'];
        }
        if ($class === 'Message' && $event === 'created') {
            return ['message_received', 'recebida'];
        }
        if ($class === 'Setting') {
            return ['settings_updated', 'alterada'];
        }
        if ($class === 'User') {
            return ['user_'.$event, ['created' => 'criado', 'updated' => 'editado', 'deleted' => 'removido'][$event]];
        }

        return [$event, ['created' => 'criado', 'updated' => 'editado', 'deleted' => 'eliminado'][$event]];
    }

    private function title(Model $model): string
    {
        foreach (['name', 'title', 'label', 'slug', 'key'] as $attr) {
            $value = $model->getAttribute($attr);
            if (filled($value)) {
                return (string) $value;
            }
        }

        return '#'.$model->getKey();
    }

    /** Changed fields as ['field' => ['de' => old, 'para' => new]], sensitive/long values filtered. */
    private function changes(Model $model): array
    {
        $out = [];
        foreach ($model->getChanges() as $key => $new) {
            if (in_array($key, self::HIDDEN, true)) {
                continue;
            }
            $out[$key] = ['de' => $this->short($model->getOriginal($key)), 'para' => $this->short($new)];
        }

        return $out;
    }

    private function short(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }
        if (is_bool($value)) {
            return $value ? 'sim' : 'não';
        }

        return mb_substr((string) $value, 0, 140);
    }
}
