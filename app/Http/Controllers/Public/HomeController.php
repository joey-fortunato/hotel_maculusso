<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    public function __invoke(Request $request, string $locale): View
    {
        app()->setLocale($locale);

        return view('public.home', [
            'locale' => $locale,
            'rooms' => Room::published()->ordered()->get(),
        ]);
    }
}
