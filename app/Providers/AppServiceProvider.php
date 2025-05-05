<?php

namespace App\Providers;

use App\Filament\Pages\DetailRT;
use App\Filament\Pages\ViewRT;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use App\Models\RT;
use Filament\Navigation\NavigationItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
