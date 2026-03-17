<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $genre = $request->query('genre');
        $search = $request->query('search');

        $query = Announcement::with('user.musicianProfile', 'user.establishmentProfile')
            ->latest();

        if ($genre && $genre !== 'all') {
            $query->where('genre', $genre);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%")
                  ->orWhere('location', 'ilike', "%{$search}%");
            });
        }

        $announcements = $query->paginate(9);

        $genres = ['Rock', 'Sertanejo', 'Blues', 'Eletrônica', 'MPB', 'Jazz', 'Pop', 'Funk'];

        return view('announcements.index', compact('announcements', 'genre', 'search', 'genres'));
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('user.musicianProfile', 'user.establishmentProfile');
        return view('announcements.show', compact('announcement'));
    }

    public function create()
    {
        $genres = ['Rock', 'Sertanejo', 'Blues', 'Eletrônica', 'MPB', 'Jazz', 'Pop', 'Funk'];
        return view('announcements.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'nullable|numeric|min:0',
            'location'    => 'nullable|string|max:255',
            'genre'       => 'nullable|string|max:100',
            'image'       => 'nullable|image|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create([
            'user_id'     => Auth::id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'] ?? null,
            'location'    => $validated['location'] ?? null,
            'genre'       => $validated['genre'] ?? null,
            'image'       => $imagePath,
        ]);

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Anúncio criado com sucesso!');
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        $genres = ['Rock', 'Sertanejo', 'Blues', 'Eletrônica', 'MPB', 'Jazz', 'Pop', 'Funk'];
        return view('announcements.edit', compact('announcement', 'genres'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'nullable|numeric|min:0',
            'location'    => 'nullable|string|max:255',
            'genre'       => 'nullable|string|max:100',
            'image'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $validated['image'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($validated);

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Anúncio atualizado com sucesso!');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Anúncio excluído com sucesso!');
    }
}
