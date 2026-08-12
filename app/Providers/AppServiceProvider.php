<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\Parameter;
use Illuminate\Support\ServiceProvider;

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
        Scramble::configure()
            ->withOperationTransformers(function (Operation $operation) {
                $operation->addParameters([
                    new Parameter(
                        name: 'Accept',
                        in: 'header',
                    ),

                    new Parameter(
                        name: 'Accept-Language',
                        in: 'header',
                    ),
                ]);
            });
    }
}