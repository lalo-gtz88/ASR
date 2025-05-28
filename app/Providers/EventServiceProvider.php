<?php

namespace App\Providers;

use App\Events\IpAssigned;
use App\Events\TicketAssigned;
use App\Events\UpdateEquipoEvent;
use App\Listeners\IpAssignedListener;
use App\Listeners\SendTelegramNotification;
use App\Listeners\UpdateEquipoListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        TicketAssigned::class => [
            SendTelegramNotification::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        Event::listen(
            UpdateEquipoEvent::class,
            [UpdateEquipoListener::class, 'handle'],

        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
