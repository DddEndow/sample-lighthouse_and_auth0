<?php


namespace App\Events;


use Pusher\Pusher;

class RealtimeChartEvent
{
    public function __construct()
    {
        //
    }

    public function run()
    {
        $pusher = new Pusher(
            config('const.pusher.app_key'),    // Replace with 'key' from dashboard
            config('const.pusher.app_secret'), // Replace with 'secret' from dashboard
            config('const.pusher.app_id'),     // Replace with 'app_id' from dashboard
            array(
                'cluster' => config('const.pusher.cluster') // Replace with 'cluster' from dashboard
            )
        );

        $i = 0;

        // Trigger a new random event every second. In your application,
        // you should trigger the event based on real-world changes!
        while (true) {
            $pusher->trigger('price-btcusd', 'new-price', array(
                'value' => rand(0, 5000)
            ));

            $i ++;
            echo('send ' . $i . ' times' . PHP_EOL);

            sleep(1);
        }
    }
}
