<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

final class ReservationController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $slugs = \App\Models\Room::published()->pluck('slug')->all();

        $data = $request->validate([
            'room' => ['required', 'string', Rule::in($slugs)],
            'checkin' => ['required', 'date'],
            'checkout' => ['required', 'date', 'after:checkin'],
            'guests' => ['required', 'integer', 'min:1', 'max:4'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'Introduza um email válido.',
            'checkout.after' => 'A data de check-out deve ser posterior ao check-in.',
            'room.in' => 'Seleccione um quarto válido.',
            'guests.max' => 'O número máximo de hóspedes é 4.',
            'max' => 'O campo :attribute é demasiado longo.',
        ], [
            'room' => 'quarto',
            'checkin' => 'check-in',
            'checkout' => 'check-out',
            'guests' => 'hóspedes',
            'name' => 'nome',
            'email' => 'email',
            'phone' => 'telefone',
        ]);

        $room = \App\Models\Room::where('slug', $data['room'])->first();

        \App\Models\Reservation::create([
            'room_slug' => $data['room'],
            'room_name' => $room?->name ?? $data['room'],
            'checkin' => $data['checkin'],
            'checkout' => $data['checkout'],
            'guests' => $data['guests'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'status' => 'pending',
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Pedido de reserva recebido.',
        ]);
    }
}
