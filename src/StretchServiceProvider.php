<?php

declare(strict_types=1);

namespace RefactorCircus\Stretch;

use RefactorCircus\Stretch\Domains\Connection\Contracts\ClientContract;
use RefactorCircus\Stretch\Domains\DomainServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * StretchServiceProvider handles the registration of Stretch services.
 *
 * Publishes the package config, registers the domain service providers
 * (connections and query builders) through DomainServiceProvider, and
 * binds the main Stretch service behind the facade.
 */
class StretchServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package settings.
     *
     * Sets up the package name and configuration file publication.
     *
     * @param  Package  $package  The package configuration instance
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('stretch')
            ->hasConfigFile();
    }

    /**
     * Register package services after the package is registered.
     *
     * This method is called automatically by the parent class and handles
     * the registration of all Stretch-related services in the container.
     */
    public function packageRegistered(): void
    {
        $this->app->register(DomainServiceProvider::class);
        $this->registerStretch();
    }

    /**
     * Register the main Stretch service.
     *
     * Registers the Stretch class as a singleton with both the default
     * client and the connection manager for multi-connection support.
     * This enables both the Stretch facade and dependency injection usage.
     */
    protected function registerStretch(): void
    {
        // Register the main Stretch service as a singleton
        // Inject both the client contract and manager for full functionality
        $this->app->singleton('stretch', function ($app): Stretch {
            return new Stretch(
                $app[ClientContract::class],
                $app['elasticsearch.manager']
            );
        });
    }
}
