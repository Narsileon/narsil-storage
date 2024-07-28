<?php

namespace Narsil\Storage\Http\Resources\Forms;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Storage\Models\Image;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class ImageResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            Image::ID => $this->{Image::ID},
            Image::PATH => $this->{Image::PATH},

            Image::ATTRIBUTE_EXTENSION => $this->{Image::ATTRIBUTE_EXTENSION},
            Image::ATTRIBUTE_FILENAME => $this->{Image::ATTRIBUTE_FILENAME},
        ];
    }

    #endregion
}
