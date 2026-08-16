<?php
namespace Modules\Banner\Services;

use App\Utils\DTO;
use Modules\Banner\Models\Banner;
use Modules\Banner\Repositories\BannerRepository;

class BannerService
{
    public function __construct(
        private BannerRepository $bannerRepository
    ) {
    }

    public function index(?bool $page = false)
    {
        return $page ? $this->bannerRepository->getPaginated() : $this->bannerRepository->getAll();
    }

    public function create(DTO $dto)
    {
        $banner = $this->bannerRepository->create($dto->getData());

        if ($dto->image) {
            $banner->addMedia($dto->image)->toMediaCollection('banners');
        }

        return $banner->fresh(['category']);
    }

    public function update(Banner $banner, DTO $dto)
    {
        $this->bannerRepository->update($banner, $dto->getData());

        if ($dto->image) {
            $banner->clearMediaCollection('banners');
            $banner->addMedia($dto->image)->toMediaCollection('banners');
        }

        return $banner->fresh(['category']);
    }

    public function delete(Banner $banner): void
    {
        $banner->clearMediaCollection('banners');
        $this->bannerRepository->delete($banner);
    }
}