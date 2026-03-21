<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Admin channel for dashboard listening
        return [
            new Channel('admin-orders'),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id ?? null,
            'tenNhanVien' => $this->order->tenNhanVien ?? null,
            'tongtien' => $this->order->tongtien ?? 0,
            'message' => 'Bạn có đơn hàng mới từ ' . ($this->order->tennguoinhan ?? 'khách hàng'),
            'time' => now()->format('H:i:s d/m/Y')
        ];
    }
}
