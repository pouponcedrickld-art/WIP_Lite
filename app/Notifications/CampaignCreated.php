<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CampaignCreated extends Notification
{
    protected $campaign;

    // On passe l'objet Campagne à la notification
    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "Nouvelle campagne lancée : " . $this->campaign->name,
            'url' => "/campaigns/" . $this->campaign->id,
            'admin_name' => auth()->user()->name,
        ];
    }
}