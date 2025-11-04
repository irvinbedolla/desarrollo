<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PendienteFirmaUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Conteo de pendientes de firma.
     */
    public int $count;

    /**
     * Constructor de eventos
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * Eventos a broadcastear :).
     */
    public function broadcastOn(): array
    {
        return [new PrivateChannel('pendiente-firma')];
    }

    /**
     * Nombre público del evento en el frontend (Laravel Echo)
     */
    public function broadcastAs(): string
    {
        return 'PendienteFirmaUpdated';
    }
}
