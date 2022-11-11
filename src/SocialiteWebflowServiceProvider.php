<?php

namespace Punchlist\SocialiteWebflow;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;

class SocialiteWebflowServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $socialite = $this->app->make(Factory::class);

        $socialite->extend('webflow', function () use ($socialite) {
            $config = config('services.webflow');

            return $socialite->buildProvider(SocialiteWebflowProvider::class, $config);
        });
    }
}
