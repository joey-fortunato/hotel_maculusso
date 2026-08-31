<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('public.home', [
            'rooms' => Room::published()->ordered()->get(),
        ]);
    }
}
