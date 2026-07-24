<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

 public function show(Event $event)
    {
        $categories = Category::all();

        return view('event-detail', compact('event', 'categories'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:1',
        'poster' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('poster')) {

        $data['poster_path'] = $request
            ->file('poster')
            ->store('posters', 'public');

    }

    Event::create($data);

    return redirect()
        ->route('admin.events.index')
        ->with('success', 'Data Event berhasil ditambahkan.');
}

public function update(Request $request, Event $event)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:1',
        'poster' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('poster')) {

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $data['poster_path'] = $request
            ->file('poster')
            ->store('posters', 'public');
    }

    $event->update($data);

    return redirect()
        ->route('admin.events.index')
        ->with('success','Event berhasil diperbarui.');
}
public function destroy(Event $event)
{
    if ($event->poster_path) {
        Storage::disk('public')->delete($event->poster_path);
    }

    $event->delete();

    return redirect()
        ->route('admin.events.index')
        ->with('success', 'Event berhasil dihapus.');
}
}
