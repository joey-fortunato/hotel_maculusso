<?php

use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NavItemController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\RestaurantItemController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Public\ContactMessageController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ReservationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/pt');

Route::post('/reservation', ReservationController::class)->name('reservation.store');
Route::post('/mensagem', [ContactMessageController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin panel (CMS)
|--------------------------------------------------------------------------
*/
Route::prefix('painel')->name('admin.')->group(function (): void {
    Route::get('login', [AuthController::class, 'show'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');

        // Maintenance mode
        Route::get('manutencao', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
        Route::put('manutencao', [MaintenanceController::class, 'update'])->name('maintenance.update');
        Route::post('manutencao/alternar', [MaintenanceController::class, 'toggle'])->name('maintenance.toggle');

        // Reservations
        Route::get('reservas', [AdminReservationController::class, 'index'])->name('reservations.index');
        Route::patch('reservas/{reservation}', [AdminReservationController::class, 'update'])->name('reservations.update');
        Route::delete('reservas/{reservation}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');

        // Contact messages
        Route::get('mensagens', [MessageController::class, 'index'])->name('messages.index');
        Route::get('mensagens/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('mensagens/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        // Pages (tabbed content editor)
        Route::get('paginas', [PagesController::class, 'edit'])->name('pages.edit');
        Route::put('paginas', [PagesController::class, 'update'])->name('pages.update');

        // Content collections
        Route::resource('rooms', RoomController::class)->except('show');
        Route::resource('services', ServiceController::class)->except('show');
        Route::resource('amenities', AmenityController::class)->except('show');
        Route::resource('testimonials', TestimonialController::class)->except('show');
        Route::resource('restaurant-items', RestaurantItemController::class)->except('show');
        Route::resource('gallery', GalleryImageController::class)->except('show');
        Route::resource('nav-items', NavItemController::class)->except('show');
    });
});

Route::prefix('{locale}')
    ->whereIn('locale', ['pt', 'en'])
    ->middleware('available')
    ->group(function (): void {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/rooms', [PageController::class, 'rooms'])->name('rooms.index');
        Route::get('/rooms/{slug}', [PageController::class, 'room'])->name('rooms.show');
        Route::get('/services', [PageController::class, 'services'])->name('services.index');
        Route::get('/restaurant', [PageController::class, 'restaurant'])->name('restaurant');
        Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
        Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    });

Route::get('/booking', function () {
    return redirect()->away(setting('booking_url', config('hotel.booking_url')));
})->middleware('available')->name('booking');
