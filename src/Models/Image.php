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

        $this->appends = [
            self::ATTRIBUTE_EXTENSION,
            self::ATTRIBUTE_FILENAME,
        ];

        $this->fillable = [
            self::ACTIVE,
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
    final public const ID = 'id';
    /**
     * @var string
     */
    final public const PATH = 'path';

    /**
     * @var string
     */
    final public const ATTRIBUTE_EXTENSION = 'extension';
    /**
     * @var string
     */
    final public const ATTRIBUTE_FILENAME = 'filename';

    /**
     * @var string
     */
    final public const TABLE = 'images';

    #endregion

    #region ATTRIBUTES

    /**
     * @return string
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->{self::PATH}, PATHINFO_EXTENSION);
    }

    /**
     * @return string
     */
    public function getFilenameAttribute(): string
    {
        return pathinfo($this->{self::PATH}, PATHINFO_FILENAME);
    }

    #endregion
}
