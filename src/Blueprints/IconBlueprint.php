<?php

namespace Narsil\Storage\Blueprints;

#region USE

use Illuminate\Database\Schema\Blueprint;
use Narsil\Storage\Models\Icon;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class IconBlueprint
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
            ->constrained(Icon::TABLE, Icon::ID)
            ->nullOnDelete();
    }

    #endregion
}
