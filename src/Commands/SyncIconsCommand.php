<?php

namespace Narsil\Storage\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Narsil\Storage\Models\Icon;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class SyncIconsCommand extends Command
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->signature = 'narsil:sync-icons';
        $this->description = 'Syncs the icons table with the storage folder';

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle()
    {
        $icons = $this->createMissingIcons();

        $this->deleteMissingIcons($icons);

        $this->info('Icons table has been successfully synced with the storage folder.');
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return array<integer>
     */
    private function createMissingIcons(): array
    {
        $path = Storage::disk('public')->path('icons');

        $files = File::allFiles($path);

        $icons = [];

        foreach ($files as $file)
        {
            if ($file->getExtension() === 'txt')
            {
                continue;
            }

            $icon = Icon::firstOrCreate([
                Icon::EXTENSION => $file->getExtension(),
                Icon::FILENAME => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                Icon::PATH => $file->getRelativePathname(),
            ]);

            $icons[] = $icon->{Icon::ID};
        }

        return $icons;
    }

    /**
     * @param array<integer> $icons
     *
     * @return void
     */
    private function deleteMissingIcons(array $icons): void
    {
        Icon::whereNotIn(Icon::ID, $icons)->delete();
    }

    #endregion
}
