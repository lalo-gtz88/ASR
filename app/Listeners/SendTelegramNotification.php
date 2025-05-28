<?php

namespace App\Listeners;

use App\Events\TicketAssigned;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTelegramNotification
{
    public TelegramService $telegram;

    /**
     * Create the event listener.
     */
    public function __construct(TelegramService $telegram)
    {

        $this->telegram = $telegram;
    }

    /**
     * Handle the event.
     */
    public function handle(TicketAssigned $event): void
    {

        $ticket = $event->ticket;

        // Notificar al técnico asignado
        $assignedUser = User::find($ticket->asignado);

        if ($assignedUser && $assignedUser->telegram) {
            $this->telegram->sendMessage(
                $assignedUser->telegram,
                "📌  <b>Se te ha asignado un nuevo ticket: #{$ticket->id} - {$ticket->tema}</b>\n" . strip_tags(mb_trim($ticket->descripcion))
            );
        }

        // Notificar a los usuarios con permiso global
        $notificables = User::permission('Recibir notificación de todos los tickets')
            ->whereNotNull('telegram')
            ->get();

        foreach ($notificables as $user) {

            if ($assignedUser) {
                if ($user->id !== $assignedUser->id && $user->telegram) {

                    $this->telegram->sendMessage(
                        $user->telegram,
                        "📣 <b>Nuevo ticket asignado: #{$ticket->id} - {$ticket->tema}\nAsignado: </b>{$assignedUser->name}\n" . strip_tags(mb_trim($ticket->descripcion))
                    );
                }
            } else {

                $this->telegram->sendMessage(
                    $user->telegram,
                    "📣 <b>Nuevo ticket creado: #{$ticket->id} - {$ticket->tema}</b>\n" . strip_tags(mb_trim($ticket->descripcion))
                );
            }
        }
    }
}
