<?php

namespace Modules\Banner\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Modules\Banner\Http\Requests\CreateBannerRequest;
use Modules\Banner\Http\Requests\UpdateBannerRequest;
use Modules\Banner\Models\Banner;
use Modules\Banner\Services\BannerService;
use Modules\Banner\Transformers\BannerResource;

class BannerController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private BannerService $bannerService)
    {
    }

    public function show(Banner $banner)
    {
        $banner->load(['category']);

        $data = new BannerResource($banner);

        return $this->success(
            data: $data
        );
    }

    public function index(PaginationRequest $request)
    {
        $banners = $this->bannerService->index($request->filled('page'));

        $data = $request->filled('page') ? new PaginationCollection($banners, 'banners', BannerResource::class) :
            BannerResource::collection($banners);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateBannerRequest $request)
    {
        $dto = DTO::FromRequest($request, ['is_external', 'category_id', 'image', 'link']);
        $banner = $this->bannerService->create($dto);

        $data = new BannerResource($banner);

        return $this->success(
            message: __('message.banner_created'),
            data: $data
        );
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $dto = DTO::FromRequest($request, ['is_external', 'category_id', 'image', 'link']);
        $banner = $this->bannerService->update($banner, $dto);

        $data = new BannerResource($banner);

        return $this->success(
            message: __('message.banner_updated'),
            data: $data
        );
    }

    public function delete(Banner $banner)
    {
        $this->bannerService->delete($banner);

        return $this->success(
            message: __('message.banner_deleted')
        );
    }
}