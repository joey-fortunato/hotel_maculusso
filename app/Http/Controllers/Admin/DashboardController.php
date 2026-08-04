<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // Reservations per day for the last 14 days
        $days = collect(range(13, 0))->map(function ($offset) {
            $date = Carbon::today()->subDays($offset);

            return [
                'label' => $date->format('d/m'),
                'count' => Reservation::whereDate('created_at', $date)->count(),
            ];
        });

        return view('admin.dashboard', [
            'chart' => $days,
            'chartMax' => max(1, $days->max('count')),
            'totals' => [
                'reservations' => Reservation::count(),
                'new' => Reservation::where('status', 'pending')->count(),
                'messages' => Message::where('is_read', false)->count(),
                'rooms' => Room::count(),
            ],
            'recentReservations' => Reservation::latest()->take(6)->get(),
            'recentMessages' => Message::latest()->take(5)->get(),
        ]);
    }
}
