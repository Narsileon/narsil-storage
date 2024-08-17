<?php

namespace Narsil\Storage\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
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

    #region PROPERTIES

    /**
     *
     * @var Collection Collection of Icon keyed by path.
     */
    private Collection $icons;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle()
    {
        $this->icons = Icon::all()->keyBy(Icon::PATH);

        $this->createMissingIcons();
        $this->deleteMissingIcons();

        $this->info('Icons table has been successfully synced with the storage folder.');
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createMissingIcons(): void
    {
        if (!Storage::disk('public')->exists('icons'))
        {
            Storage::disk('public')->makeDirectory('icons');
        }

        $path = Storage::disk('public')->path('icons');

        $files = File::allFiles($path);

        foreach ($files as $file)
        {
            if ($file->getExtension() === 'txt')
            {
                continue;
            }

            $icon = $this->getIcon($file->getRelativePathname());
        }
    }

    /**
     * @return void
     */
    private function deleteMissingIcons(): void
    {
        $ids = $this->icons->pluck(Icon::ID);

        Icon::whereNotIn(Icon::ID, $ids)->delete();
    }

    /**
     * @param string $path
     *
     * @return Icon
     */
    private function getIcon(string $path): Icon
    {
        $icon = $this->icons->get($path);

        if (!$icon)
        {
            $icon = Icon::create([
                Icon::PATH => $path,
            ]);

            $this->icons->put($path, $icon);
        }

        return $icon;
    }

    #endregion
}
