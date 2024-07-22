<?php

namespace Narsil\Storage\Models;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class Image extends Model
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->fillable = [
            self::ACTIVE,
            self::EXTENSION,
            self::FILENAME,
            self::PATH,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    final public const ACTIVE = 'active';
    /**
     * @var string
     */
    final public const EXTENSION = 'extension';
    /**
     * @var string
     */
    final public const FILENAME = 'filename';
    /**
     * @var string
     */
    final public const ID = 'id';
    /**
     * @var string
     */
    final public const PATH = 'path';

    /**
     * @var string
     */
    final public const TABLE = 'images';

    #endregion
}
