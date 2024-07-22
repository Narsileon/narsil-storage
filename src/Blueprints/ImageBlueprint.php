<?php

namespace Narsil\Storage\Blueprints;

#region USE

use Illuminate\Database\Schema\Blueprint;
use Narsil\Storage\Models\Image;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class ImageBlueprint
{
    #region PUBLIC METHODS

    /**
     * @param Blueprint $table
     * @param string $column
     *
     * @return void
     */
    public static function define(Blueprint $table, string $column): void
    {
        $table->foreignId($column)
            ->nullable()
            ->constrained(Image::TABLE, Image::ID)
            ->nullOnDelete();
    }

    #endregion
}
