<?php

namespace Narsil\Storage\Http\Controllers;

#region USE

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Narsil\Storage\Http\Requests\FetchRequest;
use Narsil\Storage\Http\Resources\Forms\IconResource;
use Narsil\Storage\Models\Icon;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class IconFetchController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @return AnonymousResourceCollection
     */
    public function __invoke(FetchRequest $request): AnonymousResourceCollection
    {
        $search = $request->validated(FetchRequest::SEARCH);

        $icons = Icon::query()
            ->where(Icon::ACTIVE, true)
            ->where(Icon::PATH, "like", "%$search%")
            ->get();

        return IconResource::collection($icons);
    }

    #endregion
}
