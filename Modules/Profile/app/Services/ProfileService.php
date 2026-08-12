<?php
namespace Modules\Profile\Services;

use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Services\AuthService;
use Modules\Profile\Repositories\ProfileRepository;

class ProfileService
{
    public function __construct(private ProfileRepository $profileRepository, private AuthService $authService)
    {
    }

    public function update(DTO $dto)
    {
        $user = $dto->user;
        $user = $this->profileRepository->update($user, $dto->getData());

        if ($dto->image) {
            $user->clearMediaCollection('users');

            $user->addMedia($dto->image)
                ->toMediaCollection('users');
        }

        return $user->fresh();
    }

    public function updatePassword(DTO $dto)
    {
        $user = $dto->user;
        if (!Hash::check($dto->current_password, $user->password)) {
            throw new BusinessException(message: __('message.wrong_password'), code: 400, errors: [__('message.wrong_password')]);
        }
        $this->profileRepository->update($user, ['password' => Hash::make($dto->new_password)]);
    }

    public function delete(User $user)
    {
        $user->clearMediaCollection('users');
        $this->authService->logout($user);
        $this->profileRepository->delete($user);
    }
}