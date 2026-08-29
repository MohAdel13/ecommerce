<?php

namespace Modules\Auth\Http\Controllers;

use App\Enums\Provider;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\SocialAuthRequest;
use Modules\Auth\Http\Requests\UpdateFcmRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        $dto = DTO::FromRequest($request, ['email', 'password']);
        $data = $this->authService->login($dto);

        return $this->success(
            message: __('message.login_success'),
            data: [
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ]
        );
    }

    public function socialAuth(SocialAuthRequest $request)
    {
        $dto = DTO::FromRequest($request, ['name', 'email', 'phone', 'uuid']);
        $dto->append(['provider' => Provider::from($request->provider)]);
        $data = $this->authService->socialAuth($dto);

        return $this->success(
            message: __('message.login_success'),
            data: [
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ]
        );
    }

    public function register(RegisterRequest $request)
    {
        $dto = DTO::FromRequest($request, ['name', 'email', 'phone', 'password']);
        $data = $this->authService->register($dto);

        return $this->success(
            message: __('message.register_success'),
            data: [
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ]
        );
    }

    public function logout()
    {
        $this->authService->logout(Auth::user());

        return $this->success(
            message: __('message.logout_success')
        );
    }

    public function updateFcm(UpdateFcmRequest $request)
    {
        $dto = DTO::FromRequest($request, ['fcm_token'], Auth::user());

        $this->authService->updateFcm($dto);

        return $this->success();
    }
}