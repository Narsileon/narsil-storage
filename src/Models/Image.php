<?php

namespace Narsil\Storage\Models;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Narsil\Localization\Casts\TransAttribute;
use Narsil\Tables\Constants\Types;

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
            self::ATTRIBUTE_SOURCE,
        ];

        $this->casts = [
            self::ACTIVE => Types::BOOLEAN,
            self::ALT => TransAttribute::class,
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
    final public const ALT = 'alt';
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
    final public const ATTRIBUTE_SOURCE = 'src';


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

    /**
     * @return string
     */
    public function getSrcAttribute(): string
    {
        return Storage::url('images' . '/' . $this->{self::PATH});
    }

    #endregion
}
