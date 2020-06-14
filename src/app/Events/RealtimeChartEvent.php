<?php


namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeChartEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function broadcastOn()
    {
        return ['price-btcusd'];
    }

    public function broadcastAs()
    {
        return 'new-price';
    }
}
