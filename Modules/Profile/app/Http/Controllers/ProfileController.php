<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Support\Facades\Auth;
use Modules\Profile\Http\Requests\UpdatePasswordRequest;
use Modules\Profile\Http\Requests\UpdateProfileRequest;
use Modules\Profile\Services\ProfileService;

class ProfileController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private ProfileService $profileService)
    {
    }

    public function show()
    {
        $data = new UserResource(Auth::user());

        return $this->success(
            data: $data
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        $dto = DTO::FromRequest($request, ['email', 'name', 'phone', 'image'], Auth::user());
        $user = $this->profileService->update($dto);

        $data = new UserResource($user);
        return $this->success(
            message: __('message.profile_updated'),
            data: $data
        );
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $dto = DTO::FromRequest($request, ['current_password', 'new_password'], Auth::user());
        $this->profileService->updatePassword($dto);

        return $this->success(
            message: __('message.profile_updated'),
        );
    }

    public function delete()
    {
        $this->profileService->delete(Auth::user());
        return $this->success(
            message: __('message.profile_deleted'),
        );
    }
}