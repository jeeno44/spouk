<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        \Event::listen('logs.*.*', function($message, $objects = array()) 
        {
            $event_name                   = explode('.', \Event::firing());
            list($log, $section, $action) = $event_name;
            
            $DBsection = \App\Models\LogType::where('section', $section)->where('action', $action)->first();
            if ( !$DBsection )
               $DBsection = \App\Models\LogType::create([
                    'section'   => $section,
                    'action'    => $action,
                    'title'     => 'soon name',
                    'color'     => '#'.dechex(rand(0x000000, 0xFFFFFF))
                ]);
            
            \App\Models\LogMessage::create([
                'log_type_id'   => $DBsection->id,
                'user_id'       => \Auth::check() ? \Auth::user()->id : $objects['user_id'],
                'message'       => $message,
                'objects'       => $objects ? serialize($objects) : ''
            ]);
        });
    }
}
