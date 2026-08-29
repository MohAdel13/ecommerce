<?php

namespace Modules\Home\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Banner\Models\Banner;
use Modules\Banner\Repositories\BannerRepository;
use Modules\Banner\Transformers\BannerResource;
use Modules\Cart\Repositories\CartRepository;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Transformers\CategoryResource;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Transformers\ProductResource;

class HomeService
{
    public function __construct(
        private BannerRepository $bannerRepository,
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private CartRepository $cartRepository,
        private NotificationRepository $notificationRepository,
    ) {
    }

    public function index(?User $user): array
    {
        $data = [];

        $banners = Cache::remember('home_banners', now()->addMinutes(30), function () {
            return [
                'banners' => $this->toArray(
                    $this->getBanners()
                ),
            ];
        });
        $data = array_merge($data, $banners);

        $categories = Cache::remember('home_categories', now()->addMinutes(30), function () {
            return [
                'categories' => $this->toArray(
                    $this->getCategories()
                ),
            ];
        });
        $data = array_merge($data, $categories);

        $best_selling = Cache::remember('home_best_selling', now()->addMinutes(30), function () {
            return [
                'best_selling' => $this->toArray(
                    $this->getBestSelling()
                ),
            ];
        });
        $data = array_merge($data, $best_selling);

        $best_offers = Cache::remember('home_best_offers', now()->addMinutes(30), function () {
            return [
                'best_offers' => $this->toArray(
                    $this->getBestOffers()
                ),
            ];
        });
        $data = array_merge($data, $best_offers);

        $data['cart_quantity'] = (int) $this->getCartQuantity($user);
        $data['unread_notifications'] = (int) $this->getUnreadNotifications($user);

        return $data;
    }

    private function getBanners()
    {
        $banners = $this->bannerRepository->getAll();

        return BannerResource::collection($banners);
    }

    private function getCategories()
    {
        $categories = $this->categoryRepository->getForHome();

        return CategoryResource::collection($categories);
    }

    private function getBestSelling()
    {
        $products = $this->productRepository->getBestSelling(10);

        return ProductResource::collection($products);
    }

    private function getBestOffers()
    {
        $products = $this->productRepository->getBestOffers(10);

        return ProductResource::collection($products);
    }

    private function getCartQuantity(?User $user)
    {
        if (!$user) {
            return 0;
        }

        return $this->cartRepository->getQuantityForUser(
            $user->id
        );
    }

    private function getUnreadNotifications(?User $user)
    {
        if (!$user) {
            return 0;
        }

        return $this->notificationRepository->getUnreadCount(
            $user->id
        );
    }

    private function toArray($resource)
    {
        return json_decode(
            json_encode($resource->response(request())->getData(true)['data']),
            true
        );
    }
}