<?php

namespace Modules\User\Services;

use App\Models\User;
use App\Utils\DTO;
use Illuminate\Support\Facades\Hash;
use Modules\User\Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function index(DTO $dto)
    {
        return $dto->page ? $this->userRepository->getPaginated($dto) :
            $this->userRepository->getAll($dto);
    }

    public function create(DTO $dto)
    {
        $data = $dto->getData();

        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }

    public function update(User $user, DTO $dto)
    {
        $data = $dto->getData();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $data);
    }

    public function updateFcmToken(User $user, ?string $fcmToken)
    {
        $this->userRepository->updateFcmToken(
            $user,
            $fcmToken
        );
    }

    public function delete(User $user)
    {
        return $this->userRepository->delete($user);
    }

    public function getRoles()
    {
        return $this->userRepository->roles();
    }
}