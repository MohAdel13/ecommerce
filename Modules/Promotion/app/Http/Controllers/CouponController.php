<?php

namespace Modules\Promotion\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\EnumResource;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Promotion\Http\Requests\CreateCouponRequest;
use Modules\Promotion\Http\Requests\UpdateCouponRequest;
use Modules\Promotion\Http\Requests\ValidateCouponRequest;
use Modules\Promotion\Models\Coupon;
use Modules\Promotion\Services\CouponService;
use Modules\Promotion\Transformers\CouponResource;

class CouponController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private CouponService $couponService)
    {
    }

    public function show(Coupon $coupon)
    {
        $data = new CouponResource($coupon);

        return $this->success(
            data: $data
        );
    }

    public function index(PaginationRequest $request)
    {
        $coupons = $this->couponService->index($request->filled('page'));

        $data = $request->filled('page') ? new PaginationCollection($coupons, 'coupons', CouponResource::class) :
            CouponResource::collection($coupons);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateCouponRequest $request)
    {
        $dto = DTO::fromRequest($request, [
            'code',
            'discount_type',
            'discount_value',
            'usage_limit',
            'usage_per_user',
            'starts_at',
            'ends_at'
        ]);

        $coupon = $this->couponService->create($dto);

        $data = new CouponResource($coupon);

        return $this->success(
            message: __('message.coupon_create_success'),
            data: $data
        );
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $dto = DTO::fromRequest($request, [
            'code',
            'discount_type',
            'discount_value',
            'usage_limit',
            'usage_per_user',
            'starts_at',
            'ends_at',
            'is_active'
        ]);

        $coupon = $this->couponService->update($coupon, $dto);

        $data = new CouponResource($coupon);

        return $this->success(
            message: __('message.coupon_update_success'),
            data: $data
        );
    }

    public function delete(Coupon $coupon)
    {
        $this->couponService->delete($coupon);

        return $this->success(
            message: __('message.coupon_delete_success')
        );
    }

    public function couponTypes()
    {
        $coupon_types = $this->couponService->getCouponTypes();

        $data = EnumResource::collection($coupon_types);

        return $this->success(
            data: $data
        );
    }

    public function validateCoupon(ValidateCouponRequest $request)
    {
        $this->couponService->validateCoupon($request->coupon_code, Auth::user());

        return $this->success();
    }
}