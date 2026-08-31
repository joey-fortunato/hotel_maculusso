<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

final class PageController extends Controller
{
    // Locale is set by the SetLocale middleware and shared with every view.

    public function rooms(): View
    {
        return view('public.rooms', ['rooms' => \App\Models\Room::published()->ordered()->get()]);
    }

    public function services(): View { return view('public.services'); }
    public function restaurant(): View { return view('public.restaurant'); }
    public function gallery(): View { return view('public.gallery'); }
    public function about(): View { return view('public.about'); }
    public function contact(): View { return view('public.contact'); }

    public function privacy(): View { return $this->legal('privacy'); }
    public function terms(): View { return $this->legal('terms'); }

    public function room(string $slug): View
    {
        $room = \App\Models\Room::published()->where('slug', $slug)->firstOrFail();

        return view('public.room', ['room' => $room]);
    }

    private function legal(string $page): View
    {
        $model = \App\Models\Page::where('key', $page)->firstOrFail();

        return view('public.legal', ['page' => $model]);
    }
}
