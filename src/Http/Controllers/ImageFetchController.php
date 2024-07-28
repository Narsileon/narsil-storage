<?php

namespace Narsil\Storage\Http\Controllers;

#region USE

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Narsil\Storage\Http\Requests\FetchRequest;
use Narsil\Storage\Http\Resources\ImageResource;
use Narsil\Storage\Models\Image;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class ImageFetchController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @return AnonymousResourceCollection
     */
    public function __invoke(FetchRequest $request): AnonymousResourceCollection
    {
        $search = $request->validated(FetchRequest::SEARCH);

        $images = Image::query()
            ->where(Image::ACTIVE, true)
            ->where(Image::PATH, "like", "%$search%")
            ->get();

        return ImageResource::collection($images);
    }

    #endregion
}
