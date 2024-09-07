<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Narsil\Storage\Models\Icon;
use Narsil\Storage\Models\Image;

#endregion

return new class extends Migration
{
    #region MIGRATIONS

    /**
     * @return void
     */
    public function up(): void
    {
        $this->createIconsTable();
        $this->createImagesTable();

        Artisan::call('narsil:sync-icons');
        Artisan::call('narsil:sync-images');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Image::TABLE);
        Schema::dropIfExists(Icon::TABLE);
    }

    #endregion

    #region TABLES

    /**
     * @return void
     */
    private function createIconsTable(): void
    {
        if (Schema::hasTable(Icon::TABLE))
        {
            return;
        }

        Schema::create(Icon::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Icon::ID);
            $table
                ->boolean(Icon::ACTIVE)
                ->default(true);
            $table
                ->string(Icon::PATH);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createImagesTable(): void
    {
        if (Schema::hasTable(Image::TABLE))
        {
            return;
        }

        Schema::create(Image::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Image::ID);
            $table
                ->boolean(Image::ACTIVE)
                ->default(true);
            $table
                ->string(Image::PATH);
            $table
                ->trans(Image::ALT);
            $table
                ->timestamps();
        });
    }

    #endregion
};
