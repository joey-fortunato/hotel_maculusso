<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

final class PageController extends Controller
{
    public function rooms(string $locale): View
    {
        app()->setLocale($locale);
        return view('public.rooms', ['locale' => $locale, 'rooms' => \App\Models\Room::published()->ordered()->get()]);
    }

    public function services(string $locale): View { return $this->render('services', $locale); }
    public function restaurant(string $locale): View { return $this->render('restaurant', $locale); }
    public function gallery(string $locale): View { return $this->render('gallery', $locale); }
    public function about(string $locale): View { return $this->render('about', $locale); }
    public function contact(string $locale): View { return $this->render('contact', $locale); }

    public function privacy(string $locale): View { return $this->legal('privacy', $locale); }
    public function terms(string $locale): View { return $this->legal('terms', $locale); }

    public function room(string $locale, string $slug): View
    {
        app()->setLocale($locale);
        $room = \App\Models\Room::published()->where('slug', $slug)->firstOrFail();

        return view('public.room', ['locale' => $locale, 'room' => $room]);
    }

    private function render(string $view, string $locale): View
    {
        app()->setLocale($locale);
        return view("public.{$view}", ['locale' => $locale]);
    }

    private function legal(string $page, string $locale): View
    {
        app()->setLocale($locale);
        $model = \App\Models\Page::where('key', $page)->firstOrFail();

        return view('public.legal', ['locale' => $locale, 'page' => $model]);
    }
}
