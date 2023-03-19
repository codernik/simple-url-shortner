<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Link;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $links = Link::where('expires_at', '<', now())->get();
            foreach ($links as $link) {
                if( $link->expiry_notified ){
                    return;
                }
                
                $user = $link->user;
                $url = 'https://51d37d23-563a-46c6-8647-d13a4e42dc08.pushnotifications.pusher.com/publish_api/v1/instances/51d37d23-563a-46c6-8647-d13a4e42dc08/publishes';
                $headers = [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('PUSHER_BEARER_TOKEN')
                ];

                $response = Http::withHeaders($headers)->post($url, [
                    'interests' => ['url-expire'],
                    'web' => [
                        'notification' => [
                            'title' => 'URL Expired',
                            'body' => "Hello $user->name, Your one of the URL ( ID: $link->id ) is expired at $link->expires_at."
                        ]
                    ],
                ]);

                if( $response->getStatusCode() == 200 ){
                    $link->expiry_notified = true;
                    $link->save();
                }

            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
