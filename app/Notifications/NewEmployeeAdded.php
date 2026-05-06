<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewEmployeeAdded extends Notification
{
    protected $employeeName;

    public function __construct($employeeName)
    {
        $this->employeeName = $employeeName;
    }

    public function via($notifiable): array
    {
        return ['database']; // Important : pour que ça apparaisse dans ton widget
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "Nouvel employé ajouté : {$this->employeeName}",
            'type' => 'creation',
        ];
    }
}