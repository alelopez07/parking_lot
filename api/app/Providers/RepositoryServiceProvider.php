<?php

namespace App\Providers;

use App\Interfaces\UserInterface;
use App\Interfaces\VehicleInterface;
use App\Repositories\UserRepository;
use App\Repositories\VehicleEntrancesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(VehicleInterface::class, VehicleEntrancesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
