<?php

namespace Narsil\Storage\Http\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class FetchRequest extends FormRequest
{
    #region CONSTANTS

    public const SEARCH = "search";

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            self::SEARCH => [
                'required',
                'string',
            ],
        ];
    }

    #endregion
}
