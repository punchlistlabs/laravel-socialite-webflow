<?php

namespace Punchlist\SocialiteWebflow\Tests;

use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\SocialiteServiceProvider;
use Orchestra\Testbench\TestCase;
use Punchlist\SocialiteWebflow\SocialiteWebflowProvider;
use Punchlist\SocialiteWebflow\SocialiteWebflowServiceProvider;

class SocialiteWebflowTest extends TestCase
{
    /** @test */
    public function test_it_can_instantiate_the_webflow_driver(): void
    {
        $factory = $this->app->make(Factory::class);

        $provider = $factory->driver('webflow');

        $this->assertInstanceOf(SocialiteWebflowProvider::class, $provider);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('services.webflow', [
            'client_id' => 'webflow-client-id',
            'client_secret' => 'webflow-secret',
            'redirect' => 'https://your-callback-url',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            SocialiteServiceProvider::class,
            SocialiteWebflowServiceProvider::class,
        ];
    }
}
