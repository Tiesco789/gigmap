<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Proposal;
use App\Notifications\NewProposalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function store(Request $request, Announcement $announcement)
    {
        // Cannot send proposal to own announcement
        if (Auth::id() === $announcement->user_id) {
            return back()->withErrors(['error' => 'Você não pode enviar uma proposta para seu próprio anúncio.']);
        }

        $validated = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $proposal = Proposal::create([
            'announcement_id' => $announcement->id,
            'sender_id'       => Auth::id(),
            'message'         => $validated['message'] ?? null,
            'status'          => 'pending',
        ]);

        // Notify the announcement owner
        $announcement->user->notify(new NewProposalNotification($proposal));

        return back()->with('success', 'Proposta enviada com sucesso! O anunciante será notificado.');
    }
}
