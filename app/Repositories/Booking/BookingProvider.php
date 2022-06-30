<?php

namespace App\Repositories\Booking;

use App\Repositories\Booking\IBookingRepository;
use Illuminate\Support\ServiceProvider;

class BookingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IBookingRepository::class, BookingRepository::class);
    }
}
