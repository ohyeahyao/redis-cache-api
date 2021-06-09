<?php

namespace App\Modules\Tutor\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Tutor\TutorRepositoryInterface;
use App\Modules\Tutor\Repositories\EloquentTutorRepository;
use App\Modules\Tutor\Repositories\RedisCacheTutorRepository;

class TutorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TutorRepositoryInterface::class, RedisCacheTutorRepository::class);

        $this->app->when(RedisCacheTutorRepository::class)
                    ->needs(TutorRepositoryInterface::class)
                    ->give(EloquentTutorRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            TutorRepositoryInterface::class
        ];
    }
}
