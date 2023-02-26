<?php

namespace JeffersonSimaoGoncalves\LaravelPackageMaker;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\AddPackage;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\ClonePackage;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Database\FactoryMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Database\MigrationMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Database\SeederMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\DeletePackageCredentials;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ChannelMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ConsoleMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\EventMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ExceptionMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\JobMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ListenerMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\MailMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ModelMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\NotificationMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ObserverMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\PolicyMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ProviderMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\RequestMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\ResourceMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\RuleMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Foundation\TestMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\NovaMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\BaseTestMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\CodecovMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\ComposerMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\ContributionMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\GitignoreMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\LicenseMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\PhpunitMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\ReadmeMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\StyleciMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Package\TravisMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\PackageMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Replace;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Routing\ControllerMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Routing\MiddlewareMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\SavePackageCredentials;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Standard\AnyMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Standard\ContractMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Standard\InterfaceMakeCommand;
use JeffersonSimaoGoncalves\LaravelPackageMaker\Commands\Standard\TraitMakeCommand;

class LaravelPackageMakerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(MigrationCreator::class)
            ->needs('$customStubPath')
            ->give(function ($app) {
                return $app->basePath('stubs');
            });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands(
            array_merge(
                $this->routingCommands(),
                $this->packageCommands(),
                $this->databaseCommands(),
                $this->standardCommands(),
                $this->foundationCommands(),
                $this->packageInternalCommands()
            )
        );
    }

    /**
     * Get package database related commands.
     *
     * @return array
     */
    protected function databaseCommands()
    {
        return [
            SeederMakeCommand::class,
            FactoryMakeCommand::class,
            MigrationMakeCommand::class,
        ];
    }

    /**
     * Get package foundation related commands.
     *
     * @return array
     */
    protected function foundationCommands()
    {
        return [
            JobMakeCommand::class,
            MailMakeCommand::class,
            TestMakeCommand::class,
            RuleMakeCommand::class,
            EventMakeCommand::class,
            ModelMakeCommand::class,
            PolicyMakeCommand::class,
            ConsoleMakeCommand::class,
            RequestMakeCommand::class,
            ChannelMakeCommand::class,
            ProviderMakeCommand::class,
            ListenerMakeCommand::class,
            ObserverMakeCommand::class,
            ResourceMakeCommand::class,
            ExceptionMakeCommand::class,
            NotificationMakeCommand::class,
        ];
    }

    /**
     * Get package related commands.
     *
     * @return array
     */
    protected function packageCommands()
    {
        return [
            NovaMakeCommand::class,
            ReadmeMakeCommand::class,
            TravisMakeCommand::class,
            LicenseMakeCommand::class,
            PhpunitMakeCommand::class,
            StyleciMakeCommand::class,
            CodecovMakeCommand::class,
            ComposerMakeCommand::class,
            BaseTestMakeCommand::class,
            GitignoreMakeCommand::class,
            ContributionMakeCommand::class,
        ];
    }

    /**
     * Get package internal related commands.
     *
     * @return array
     */
    protected function packageInternalCommands()
    {
        return [
            Replace::class,
            AddPackage::class,
            ClonePackage::class,
            PackageMakeCommand::class,
            SavePackageCredentials::class,
            DeletePackageCredentials::class,
        ];
    }

    /**
     * Get package routing related commands.
     *
     * @return array
     */
    protected function routingCommands()
    {
        return [
            ControllerMakeCommand::class,
            MiddlewareMakeCommand::class,
        ];
    }

    /**
     * Get standard related commands.
     *
     * @return array
     */
    protected function standardCommands()
    {
        return [
            AnyMakeCommand::class,
            TraitMakeCommand::class,
            ContractMakeCommand::class,
            InterfaceMakeCommand::class,
        ];
    }
}
