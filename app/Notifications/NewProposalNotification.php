<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProposalNotification extends Notification
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
            'proposal_id'      => $this->proposal->id,
            'announcement_id'  => $this->proposal->announcement_id,
            'announcement_title' => $this->proposal->announcement->title,
            'sender_name'      => $this->proposal->sender->getDisplayName(),
            'message'          => $this->proposal->message,
        ];
    }
}
