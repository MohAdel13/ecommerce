<?php
namespace Modules\Profile\Repositories;

use App\Models\User;

class ProfileRepository
{
    public function update(User $user, array $data)
    {
        $user->update($data);

        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}