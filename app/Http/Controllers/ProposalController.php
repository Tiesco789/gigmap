<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Chat;
use App\Models\Proposal;
use App\Notifications\NewProposalNotification;
use App\Notifications\ProposalAcceptedNotification;
use App\Notifications\ProposalRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Send a new monetary proposal from the announcement page.
     */
    public function store(Request $request, Announcement $announcement)
    {
        // Cannot send proposal to own announcement
        if (Auth::id() === $announcement->user_id) {
            return back()->withErrors(['error' => 'Você não pode enviar uma proposta para seu próprio anúncio.']);
        }

        $validated = $request->validate([
            'value'     => 'nullable|numeric|min:0.01|max:9999999.99',
            'negotiate' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $owner = $announcement->user;

        // Determine musician/establishment for the chat
        $musicianId      = $user->isMusician() ? $user->id : $owner->id;
        $establishmentId = $user->isEstablishment() ? $user->id : $owner->id;

        // Create or retrieve existing chat
        $chat = Chat::firstOrCreate([
            'musician_id'      => $musicianId,
            'establishment_id' => $establishmentId,
        ]);

        // Determine proposal value
        $isNegotiate = !empty($validated['negotiate']);
        $value       = $isNegotiate ? null : ($validated['value'] ?? null);

        // Validate: either negotiate or valid value
        if (!$isNegotiate && ($value === null || $value <= 0)) {
            return back()->withErrors(['value' => 'Informe um valor válido ou marque "A negociar".']);
        }

        // Create the proposal
        $proposal = Proposal::create([
            'announcement_id' => $announcement->id,
            'sender_id'       => Auth::id(),
            'value'           => $value,
            'chat_id'         => $chat->id,
            'status'          => 'pending',
        ]);

        // Create a proposal message in the chat
        $chat->messages()->create([
            'sender_id'   => Auth::id(),
            'body'        => $this->buildProposalMessageBody($proposal, $announcement),
            'type'        => 'proposal',
            'proposal_id' => $proposal->id,
        ]);

        // Update last_message_at
        $chat->update(['last_message_at' => now()]);

        // Notify the announcement owner
        $owner->notify(new NewProposalNotification($proposal));

        return redirect()->route('chats.show', $chat)
            ->with('success', 'Proposta enviada com sucesso!');
    }

    /**
     * Accept a pending proposal.
     */
    public function accept(Request $request, Proposal $proposal)
    {
        $this->authorizeProposalAction($proposal);

        if (!$proposal->isPending()) {
            return $this->respondWithError($request, 'Esta proposta já foi respondida.');
        }

        $proposal->update(['status' => 'accepted']);

        // Notify the proposal sender
        $proposal->sender->notify(new ProposalAcceptedNotification($proposal));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => 'accepted',
                'message' => 'Proposta aceita com sucesso!',
            ]);
        }

        return back()->with('success', 'Proposta aceita com sucesso!');
    }

    /**
     * Reject a pending proposal.
     */
    public function reject(Request $request, Proposal $proposal)
    {
        $this->authorizeProposalAction($proposal);

        if (!$proposal->isPending()) {
            return $this->respondWithError($request, 'Esta proposta já foi respondida.');
        }

        $proposal->update(['status' => 'rejected']);

        // Notify the proposal sender
        $proposal->sender->notify(new ProposalRejectedNotification($proposal));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status'  => 'rejected',
                'message' => 'Proposta recusada.',
            ]);
        }

        return back()->with('success', 'Proposta recusada.');
    }

    // ── Private helpers ──────────────────────────────

    /**
     * Only the recipient of the proposal (who is in the chat and did not send it) can accept/reject.
     */
    private function authorizeProposalAction(Proposal $proposal): void
    {
        $userId = (int) Auth::id();
        $chat = $proposal->chat;

        if ($chat) {
            // O usuário logado deve ser um dos participantes do chat
            if ($userId !== (int) $chat->musician_id && $userId !== (int) $chat->establishment_id) {
                abort(403, 'Você não tem permissão para responder a esta proposta.');
            }

            // O usuário logado deve ser o destinatário da proposta (não quem a enviou)
            if ($userId === (int) $proposal->sender_id) {
                abort(403, 'Você não pode responder à sua própria proposta.');
            }
        } else {
            // Fallback para propostas legadas sem chat
            $announcement = $proposal->announcement;
            if (!$announcement || $userId !== (int) $announcement->user_id) {
                abort(403, 'Você não tem permissão para responder a esta proposta.');
            }
        }
    }

    /**
     * Build a human-readable body for the proposal message (fallback text).
     */
    private function buildProposalMessageBody(Proposal $proposal, Announcement $announcement): string
    {
        $value = $proposal->getFormattedValue();
        return "📋 Proposta para \"{$announcement->title}\": {$value}";
    }

    /**
     * Return error response for JSON or redirect.
     */
    private function respondWithError(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], 422);
        }

        return back()->withErrors(['error' => $message]);
    }
}
