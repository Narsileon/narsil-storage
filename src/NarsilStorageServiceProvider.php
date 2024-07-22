<?php

namespace Narsil\Storage;

#region USE

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Narsil\Storage\Blueprints\IconBlueprint;
use Narsil\Storage\Blueprints\ImageBlueprint;
use Narsil\Storage\Commands\SyncIconsCommand;
use Narsil\Storage\Commands\SyncImagesCommand;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class NarsilStorageServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->bootBlueprints();
        $this->bootCommands();
        $this->bootMigrations();
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function bootBlueprints(): void
    {
        Blueprint::macro('icon', function (string $column)
        {
            IconBlueprint::define($this, $column);
        });
        Blueprint::macro('image', function (string $column)
        {
            ImageBlueprint::define($this, $column);
        });
    }

    /**
     * @return void
     */
    private function bootCommands(): void
    {
        $this->commands([
            SyncIconsCommand::class,
            SyncImagesCommand::class,
        ]);
    }

    /**
     * @return void
     */
    private function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations',
        ]);
    }

    #endregion
}
