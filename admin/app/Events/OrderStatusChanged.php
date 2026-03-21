<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    private $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($order, $userId)
    {
        $this->order = $order;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Public channel mapped to user ID for easy client-side listening
        // For higher security, this should be an encrypted PrivateChannel.
        return [
            new Channel('user.order.' . $this->userId),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id ?? null,
            'status' => $this->order->trangthai ?? 0,
            'time' => now()->format('H:i:s d/m/Y')
        ];
    }
}
