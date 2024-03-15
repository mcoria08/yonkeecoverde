<?php

namespace App\Providers;

use App\Models\CashBox;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Determine if the cash box is open
            $user_id = Auth::id();
            $cashBox = CashBox::whereNull('closed_at')
                ->where('opened_by', $user_id)
                ->latest()
                ->first();

            if ($cashBox) {
                $event->menu->add([
                    'text' => ' Cerrar Caja',
                    'url' => '/cerrar-caja',
                    'icon' => 'fas fa-cash-register',
                ]);
            } else {
                $event->menu->add([
                    'text' => ' Abrir Caja',
                    'url' => '/venta-nueva',
                    'icon' => 'fas fa-cash-register',

                ]);
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
