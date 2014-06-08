<?php namespace Tipszonen\Notifications;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider {

    /**
     * Create binding
     */
    public function register()
    {
        $this->app->bindShared('flash', function()
        {
            return $this->app->make('Tipszonen\Notifications\FlashNotifier');
        });
    }

}