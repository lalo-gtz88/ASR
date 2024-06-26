<?php

namespace App\Jobs;

use App\Mail\NotificationTickets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProccessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->details['email'])->send(
            new NotificationTickets(
                $this->details['tipo'], 
                $this->details['user'], 
                $this->details['creator'], 
                $this->details['asignado'],
                $this->details['header'],
                $this->details['descripcion'],
                $this->details['prioridad'],
                $this->details['cambios'],
            ));   
    }
}
