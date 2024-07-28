<?php

namespace Narsil\Storage\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Narsil\Storage\Models\Image;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class SyncImagesCommand extends Command
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->signature = 'narsil:sync-images';
        $this->description = 'Syncs the images table with the storage folder';

        parent::__construct();
    }

    #endregion

    #region PROPERTIES

    /**
     *
     * @var Collection Collection of Image keyed by path.
     */
    private Collection $images;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle()
    {
        $this->images = Image::all()->keyBy(Image::PATH);

        $this->createMissingImages();
        $this->deleteMissingImages();

        $this->info('Images table has been successfully synced with the storage folder.');
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createMissingImages(): void
    {
        $path = Storage::disk('public')->path('images');

        $files = File::files($path);

        foreach ($files as $file)
        {
            if ($file->getExtension() === 'txt')
            {
                continue;
            }

            $image = $this->getImage($file->getRelativePathname());
        };
    }

    /**
     * @return void
     */
    private function deleteMissingImages(): void
    {
        $ids = $this->images->pluck(Image::ID);

        Image::whereNotIn(Image::ID, $ids)->delete();
    }

    /**
     * @param string $path
     *
     * @return Image
     */
    private function getImage(string $path): Image
    {
        $image = $this->images->get($path);

        if (!$image)
        {
            $image = Image::create([
                Image::PATH => $path,
            ]);

            $this->images->put($path, $image);
        }

        return $image;
    }

    #endregion
}
