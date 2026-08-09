<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use App\Observers\GlobalObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
{
    \App\Models\DonasiBarang::observe(\App\Observers\DonasiBarangObserver::class);
    \App\Models\PenerimaanDonasi::observe(\App\Observers\PenerimaanDonasiObserver::class);
}
}