<?php

namespace Modules\Auth\Services;

use App\Enums\Role;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\User\Repositories\UserRepository;

class AuthService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function login(DTO $dto)
    {
        $user = $this->userRepository->findByEmail($dto->email);
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
        $user = $this->userRepository->findByEmail($dto->email);

        if ($user) {
            if (($user->uuid !== $dto->uuid || $user->provider !== $dto->provider)) {
                throw new BusinessException(message: __('message.email_already_taken'), code: 400, errors: [__('message.email_already_taken')]);
            }

            return $this->authenticate($user);
        }

        $dto->append(['role' => Role::Customer]);

        $user = $this->userRepository->create($dto->getData());

        return $this->authenticate($user);
    }

    public function register(DTO $dto)
    {
        $dto->append(['role' => Role::Customer]);
        $data = $dto->getData();

        $data['password'] = Hash::make($dto->password);

        $user = $this->userRepository->create($data);

        return $this->authenticate($user);
    }

    private function authenticate(User $user)
    {
        $this->logout($user);

        $token = $this->userRepository->createToken($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(User $user)
    {
        $this->userRepository->deleteTokens($user);
    }

    public function updateFcm(DTO $dto)
    {
        $this->userRepository->update($dto->user, $dto->getData());
    }
}