<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $ticketId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Enviamos un log
        Log::info('Ejecutando envio de Telegram para el ticket: ' . $this->ticketId);

        //Obtenemos el ticket
        $ticket = Ticket::find($this->ticketId);

        if (!$ticket) {
            return;
        }

        //Utilizamos el servicio de telegram
        $service = app(TelegramService::class);


        // Notificar al técnico asignado
        $assignedUser = User::find($ticket->asignado);

        if ($assignedUser && $assignedUser->telegram) {
            $service->sendMessage(
                $assignedUser->telegram,
                "📌  <b>Se te ha asignado un nuevo ticket: #{$ticket->id} - {$ticket->tema}</b>\n" . html_entity_decode(strip_tags(mb_strimwidth($ticket->descripcion, 0, 300, '...')))
            );
        }

        // Notificar a los usuarios con permiso global
        $notificables = User::permission('Recibir notificación de todos los tickets')
            ->whereNotNull('telegram')
            ->get();

        foreach ($notificables as $user) {

            if ($assignedUser) {
                if ($user->id !== $assignedUser->id && $user->telegram) {

                    $service->sendMessage(
                        $user->telegram,
                        "📣 <b>Nuevo ticket asignado: #{$ticket->id} - {$ticket->tema}\nAsignado: </b>{$assignedUser->name}\n" . html_entity_decode(strip_tags(mb_strimwidth($ticket->descripcion, 0, 300, '...')))
                    );
                }
            } else {

                $service->sendMessage(
                    $user->telegram,
                    "📣 <b>Nuevo ticket creado: #{$ticket->id} - {$ticket->tema}</b>\n" . html_entity_decode(strip_tags(mb_strimwidth($ticket->descripcion, 0, 300, '...')))
                );
            }
        }
    }
}
