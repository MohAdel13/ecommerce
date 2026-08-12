<?php

namespace Modules\Auth\Services;

use App\Enums\Role;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function login(DTO $dto)
    {
        $user = User::where('email', $dto->email)->first();
        if (!$user) {
            throw new BusinessException(message: __('message.wrong_credintials'), code: 400, errors: [__('message.wrong_credintials')]);
        }

        if (!Hash::check($dto->password, $user->password)) {
            throw new BusinessException(message: __('message.wrong_credintials'), code: 400, errors: [__('message.wrong_credintials')]);
        }

        return $this->authenticate($user);
    }

    public function socialAuth(DTO $dto)
    {
        $user = User::where('email', $dto->email)->first();

        if ($user) {
            if (($user->uuid !== $dto->uuid || $user->provider !== $dto->provider)) {
                throw new BusinessException(message: __('message.email_already_taken'), code: 400, errors: [__('message.email_already_taken')]);
            }

            return $this->authenticate($user);
        }

        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'provider' => $dto->provider,
            'uuid' => $dto->uuid,
            'role' => Role::Customer,
        ]);

        return $this->authenticate($user);
    }

    public function register(DTO $dto)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'password' => Hash::make($dto->password),
            'role' => Role::Customer,
        ]);

        return $this->authenticate($user);
    }

    private function authenticate(User $user)
    {
        $user->tokens()->delete();

        $token = $user->createToken($user->name)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();
    }
}