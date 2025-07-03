<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Observers\AuditoriaObserver;

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
        Schema::defaultStringLength(191);

        // Aplica o AuditoriaObserver dinamicamente para todas as models em app/Models
        $modelPath = app_path('Models');

        foreach (File::allFiles($modelPath) as $file) {
            $class = 'App\\Models\\' . Str::replaceLast('.php', '', $file->getFilename());

            if (class_exists($class) && is_subclass_of($class, Model::class) && $class !== \App\Models\AuditoriaUser::class) {
                $class::observe(AuditoriaObserver::class);
            }
        }

    }
}

