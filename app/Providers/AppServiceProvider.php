<?php

namespace App\Providers;

use App\Models\AuditLog;
use App\Observers\AuditObserver;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Domain models whose changes are recorded in the audit trail. */
    private const AUDITED = [
        \App\Models\Room::class,
        \App\Models\Service::class,
        \App\Models\Amenity::class,
        \App\Models\Testimonial::class,
        \App\Models\RestaurantItem::class,
        \App\Models\GalleryImage::class,
        \App\Models\NavItem::class,
        \App\Models\Page::class,
        \App\Models\Reservation::class,
        \App\Models\Message::class,
        \App\Models\Setting::class,
        \App\Models\User::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Record create/update/delete on all audited models.
        foreach (self::AUDITED as $model) {
            $model::observe(AuditObserver::class);
        }

        // Record authentication activity.
        Event::listen(Login::class, fn (Login $e) => AuditLog::record('login', $e->user, 'Iniciou sessão no painel'));
        Event::listen(Logout::class, function (Logout $e) {
            if ($e->user) {
                AuditLog::record('logout', $e->user, 'Terminou sessão', actorName: $e->user->name);
            }
        });
        Event::listen(Failed::class, function (Failed $e) {
            $email = $e->credentials['email'] ?? 'desconhecido';
            AuditLog::record('login_failed', null, "Tentativa de login falhada ({$email})", actorName: $email);
        });
    }
}
