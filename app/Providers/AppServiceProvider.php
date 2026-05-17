<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        // Paginator bawaan Bosku (Biarkan kalau ada)
        // \Illuminate\Pagination\Paginator::useBootstrap();

        // --- CARA BARU YANG LEBIH KUAT UNTUK GLOBAL VARIABEL ---
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                // Ambil data dari database CMS
                $cms = \Illuminate\Support\Facades\DB::table('jualan_kopi.settings')->pluck('value', 'key')->toArray();
                $view->with('cms', $cms);
            } catch (\Exception $e) {
                // Jika error, kirim array kosong agar web tidak mati
                $view->with('cms', []);
            }
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

        Password::defaults(fn (): ?Password => app()->isProduction()
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
