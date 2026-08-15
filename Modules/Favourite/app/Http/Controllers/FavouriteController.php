<?php

namespace Modules\Favourite\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Support\Facades\Auth;
use Modules\Favourite\Http\Requests\FavouriteRequest;
use Modules\Favourite\Services\FavouriteService;
use Modules\Favourite\Transformers\FavouriteResource;

class FavouriteController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private FavouriteService $favouriteService)
    {
    }
    public function index()
    {
        $favourites = Auth::user()->favourites;

        $data = FavouriteResource::collection($favourites);

        return $this->success(
            data: $data
        );
    }

    public function modify(FavouriteRequest $request)
    {
        $dto = DTO::FromRequest($request, ['product_id'], Auth::user());

        $this->favouriteService->modify($dto);

        return $this->success(
            message: __('message.favourites_list_updated')
        );
    }
}