<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class RoomController extends Controller
{
    public function index(): View
    {
        return view('admin.rooms.index', ['rooms' => Room::ordered()->get()]);
    }

    public function create(): View
    {
        return view('admin.rooms.form', ['room' => new Room(['is_published' => true, 'max_guests' => 2])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Room::create($this->validated($request));

        return redirect()->route('admin.rooms.index')->with('status', 'Quarto criado.');
    }

    public function edit(Room $room): View
    {
        return view('admin.rooms.form', ['room' => $room]);
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $room->update($this->validated($request, $room));

        return redirect()->route('admin.rooms.index')->with('status', 'Quarto actualizado.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return back()->with('status', 'Quarto eliminado.');
    }

    private function validated(Request $request, ?Room $room = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'name_en' => ['nullable', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:160'],
            'tagline_en' => ['nullable', 'string', 'max:160'],
            'price' => ['required', 'integer', 'min:0'],
            'price_double' => ['required', 'integer', 'min:0'],
            'max_guests' => ['required', 'integer', 'min:1', 'max:10'],
            'size' => ['nullable', 'string', 'max:80'],
            'bed' => ['nullable', 'string', 'max:120'],
            'bed_en' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string'],
            'amenities_en' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'gallery' => ['nullable', 'array'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['image', 'max:4096'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // Auto-derived fields (hidden from the form)
        $data['slug'] = $this->uniqueSlug($data['name'], $room);
        $data['guests'] = $data['max_guests'].' '.($data['max_guests'] == 1 ? 'hóspede' : 'hóspedes');
        $data['detail'] = collect([$data['guests'], $data['size'] ?? null, $data['bed'] ?? null])
            ->filter()->implode(' · ');

        $data['amenities'] = collect(explode("\n", (string) $request->input('amenities')))
            ->map(fn ($a) => trim($a))->filter()->values()->all();
        $data['amenities_en'] = collect(explode("\n", (string) $request->input('amenities_en')))
            ->map(fn ($a) => trim($a))->filter()->values()->all();
        $data['is_published'] = $request->boolean('is_published');

        // Main image
        if ($request->hasFile('image_file')) {
            $data['image'] = '/storage/'.$request->file('image_file')->store('rooms', 'public');
        } elseif (! empty($data['image_url'])) {
            $data['image'] = $data['image_url'];
        } elseif ($room) {
            $data['image'] = $room->image;
        }

        // Gallery: kept URLs + newly uploaded files
        $gallery = collect($request->input('gallery', []))->map(fn ($g) => trim((string) $g))->filter();
        foreach ($request->file('gallery_files', []) as $file) {
            $gallery->push('/storage/'.$file->store('rooms', 'public'));
        }
        $data['gallery'] = $gallery->values()->all();

        unset($data['image_url'], $data['image_file'], $data['gallery_files']);

        return $data;
    }

    private function uniqueSlug(string $name, ?Room $room): string
    {
        $base = Str::slug($name) ?: 'quarto';
        $slug = $base;
        $i = 2;
        while (Room::where('slug', $slug)->when($room, fn ($q) => $q->where('id', '!=', $room->id))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
