<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->withErrors(['error' => 'Você não pode avaliar a si mesmo.']);
        }
        $user->load(['musicianProfile', 'establishmentProfile', 'announcements']);
        return view('reviews.create', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->withErrors(['error' => 'Você não pode avaliar a si mesmo.']);
        }

        $validated = $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        Review::create([
            'reviewer_id'       => Auth::id(),
            'reviewed_user_id'  => $user->id,
            'description'       => $validated['description'],
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Avaliação enviada com sucesso!');
    }
}
