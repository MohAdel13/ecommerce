<?php

namespace Modules\Promotion\Services;

use App\Enums\DiscountType;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Modules\Promotion\Models\Coupon;
use Modules\Promotion\Repositories\CouponRepository;

class CouponService
{
    public function __construct(private CouponRepository $couponRepository)
    {
    }

    public function index(bool $page)
    {
        return $page ? $this->couponRepository->getPaginatedCoupons() : $this->couponRepository->getAllCoupons();
    }

    public function create(DTO $dto)
    {
        return $this->couponRepository->create($dto->getData());
    }

    public function update(Coupon $coupon, DTO $dto)
    {
        return $this->couponRepository->update($coupon, $dto->getData());
    }

    public function delete(Coupon $coupon): void
    {
        $this->couponRepository->delete($coupon);
    }

    public function getCouponTypes()
    {
        return $this->couponRepository->getCouponTypes();
    }

    public function calculateCouponDiscount(Coupon $coupon, float $amount)
    {
        if ($coupon->discount_type === DiscountType::PERCENTAGE) {
            return $amount * ($coupon->discount_value / 100);
        }

        return $coupon->discount_value;
    }

    public function getCoupon(string $code)
    {
        return $this->couponRepository->findByCode($code);
    }

    public function validateCoupon(string $couponCode, User $user)
    {
        $coupon = $this->getCoupon($couponCode);

        if (!$coupon) {
            throw new BusinessException(
                message: __('message.coupon_not_found'),
                code: 404,
                errors: [__('message.coupon_not_found')]
            );
        }

        if (
            !$coupon->is_active ||
            now()->lt($coupon->starts_at) ||
            now()->gt($coupon->ends_at)
        ) {
            throw new BusinessException(
                message: __('message.coupon_not_available'),
                code: 400,
                errors: [__('message.coupon_not_available')]
            );
        }

        $totalUsage = $coupon->users()->count();

        if (
            $coupon->usage_limit !== null &&
            $totalUsage >= $coupon->usage_limit
        ) {
            throw new BusinessException(
                message: __('message.coupon_usage_limit_reached'),
                code: 400,
                errors: [__('message.coupon_usage_limit_reached')]
            );
        }

        $userUsage = $user->coupons()
            ->where('coupon_id', $coupon->id)
            ->count();

        if (
            $coupon->usage_per_user !== null &&
            $userUsage >= $coupon->usage_per_user
        ) {
            throw new BusinessException(
                message: __('message.coupon_user_limit_reached'),
                code: 400,
                errors: [__('message.coupon_user_limit_reached')]
            );
        }

        return $coupon;
    }

    public function useCoupon(User $user, int $coupon_id)
    {
        $this->couponRepository->useCoupon($user, $coupon_id);
    }
}