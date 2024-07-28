<?php

namespace Narsil\Framework\Http\Resources\Forms;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Storage\Models\Icon;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class IconResource extends JsonResource
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
            Icon::ID => $this->{Icon::ID},
            Icon::PATH => $this->{Icon::PATH},

            Icon::ATTRIBUTE_EXTENSION => $this->{Icon::ATTRIBUTE_EXTENSION},
            Icon::ATTRIBUTE_FILENAME => $this->{Icon::ATTRIBUTE_FILENAME},
        ];
    }

    #endregion
}
