<?php

namespace Modules\User\Repositories;

use App\Enums\Role;
use App\Models\User;
use App\Utils\DTO;

class UserRepository
{
    public function query(DTO $dto)
    {
        return User::query()
            ->when(
                $dto->role,
                fn($query) => $query->where('role', $dto->role)
            )->when(
                $dto->search,
                fn($query) => $query->where(function ($q) use ($dto) {
                    $q->where('name', 'like', "%{$dto->search}%")
                        ->orWhere('phone', 'like', "%{$dto->search}%")
                        ->orWhere('email', 'like', "%{$dto->search}%");
                })
            );
    }

    public function getAll(DTO $dto)
    {
        return $this->query($dto)->get();
    }

    public function getPaginated(DTO $dto)
    {
        return $this->query($dto)->paginate(15, ['*'], 'page');
    }

    public function findById(int $id)
    {
        return User::find($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function findByPhone(string $phone)
    {
        return User::where('phone', $phone)->first();
    }

    public function findByFcm(?string $fcmToken)
    {
        if (!$fcmToken) {
            return null;
        }
        return User::where('fcm_token', $fcmToken)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);

        return $user->fresh();
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function updatePassword(User $user, string $password)
    {
        $user->update([
            'password' => $password,
        ]);

        return $user->fresh();
    }

    public function updateFcmToken(User $user, ?string $fcmToken)
    {
        $user->update([
            'fcm_token' => $fcmToken,
        ]);

        return $user->fresh();
    }

    public function deleteTokens(User $user)
    {
        $user->tokens()->delete();
    }

    public function createToken(User $user)
    {
        return $user->createToken($user->name)->plainTextToken;
    }

    public function roles()
    {
        return Role::cases();
    }
}