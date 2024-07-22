<?php

namespace Narsil\Storage\Commands;

#region USE

use Illuminate\Console\Command;
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

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle()
    {
        $images = $this->createMissingImages();

        $this->deleteMissingImages($images);

        $this->info('Images table has been successfully synced with the storage folder.');
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return array<integer>
     */
    private function createMissingImages(): array
    {
        $path = Storage::disk('public')->path('images');

        $files = File::files($path);

        $images = [];

        foreach ($files as $file)
        {
            if ($file->getExtension() === 'txt')
            {
                continue;
            }

            $image = Image::firstOrCreate([
                Image::EXTENSION => $file->getExtension(),
                Image::FILENAME => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                Image::PATH => $file->getRelativePathname(),
            ]);

            $images[] = $image->{Image::ID};
        }

        return $images;
    }

    /**
     * @param array<integer> $images
     *
     * @return void
     */
    private function deleteMissingImages(array $images): void
    {
        Image::whereNotIn(Image::ID, $images)->delete();
    }

    #endregion
}
