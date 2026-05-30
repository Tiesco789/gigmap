<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalAcceptedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Proposal $proposal
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'               => 'proposal_accepted',
            'proposal_id'        => $this->proposal->id,
            'announcement_id'    => $this->proposal->announcement_id,
            'announcement_title' => $this->proposal->announcement->title,
            'chat_id'            => $this->proposal->chat_id,
            'responder_name'     => $this->proposal->announcement->user->getDisplayName(),
            'value'              => $this->proposal->getFormattedValue(),
        ];
    }
}
