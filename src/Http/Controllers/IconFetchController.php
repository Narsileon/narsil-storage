<?php

namespace Narsil\Storage\Http\Controllers;

#region USE

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Narsil\Storage\Http\Requests\FetchRequest;
use Narsil\Storage\Http\Resources\IconResource;
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

        Log::info($search);
        $icons = Icon::query()
            ->where(Icon::ACTIVE, true)
            ->where(Icon::PATH, "like", "%$search%")
            ->get();
        Log::info($icons->toArray());

        return IconResource::collection($icons);
    }

    #endregion
}
