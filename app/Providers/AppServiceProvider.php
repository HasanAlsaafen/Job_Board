<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

use Illuminate\Notifications\DatabaseNotification;
use App\Observers\DatabaseNotificationObserver;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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

        $this->configureDefaults();
        Carbon::setLocale(app()->getLocale());
        DatabaseNotification::observe(DatabaseNotificationObserver::class);

        FilamentColor::register([
            'primary' => Color::hex('#4F46E5'),
        ]);
        RateLimiter::for('api', function ( $request) {
        return Limit::perMinute(10)
            ->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('guest', function ( $request) {
        return Limit::perMinute(5)
            ->by($request->ip())
            ->response(function () {
                return response()->json([
                    'message' => 'Too many login attempts. Please try again later.',
                ], 429);
            });
    });

    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null,
        );
    }
}