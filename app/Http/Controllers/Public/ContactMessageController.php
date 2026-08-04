<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'body' => ['required', 'string', 'max:5000'],
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'Introduza um email válido.',
        ], [
            'name' => 'nome',
            'email' => 'email',
            'body' => 'mensagem',
        ]);

        Message::create($data);

        return back()->with('contact_sent', true);
    }
}
