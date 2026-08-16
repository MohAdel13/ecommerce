<?php

namespace Modules\Promotion\Repositories;

use App\Enums\DiscountType;
use App\Models\User;
use Modules\Promotion\Models\Coupon;

class CouponRepository
{
    public function getCouponTypes()
    {
        return DiscountType::cases();
    }

    public function getAllCoupons()
    {
        return $this->queryCoupons()->get();
    }

    public function getPaginatedCoupons()
    {
        return $this->queryCoupons()->paginate(15, ['*'], 'page');
    }

    public function queryCoupons()
    {
        return Coupon::latest();
    }

    public function create(array $data)
    {
        return Coupon::create($data);
    }

    public function update(Coupon $coupon, array $data)
    {
        $coupon->update($data);

        return $coupon->refresh();
    }

    public function delete(Coupon $coupon)
    {
        $coupon->delete();
    }

    public function findByCode(string $code)
    {
        return Coupon::where('code', $code)->first();
    }

    public function useCoupon(User $user, int $coupon_id)
    {
        $user->coupons()->attach($coupon_id);
    }
}