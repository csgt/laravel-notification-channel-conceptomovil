<?php
namespace NotificationChannels\Conceptomovil;

use Illuminate\Support\ServiceProvider;

class ConceptomovilProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ConceptomovilChannel::class)
            ->needs(Conceptomovil::class)
            ->give(function () {
                return new Conceptomovil(
                    $this->app->make(ConceptomovilConfig::class)
                );
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(ConceptomovilConfig::class, function () {
            return new ConceptomovilConfig($this->app['config']['services.conceptomovil']);
        });
    }
}
