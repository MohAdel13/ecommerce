<?php

namespace Modules\Address\Repositories;

use App\Models\User;
use Modules\Address\Models\Address;

class AddressRepository
{
    public function getUserAddresses(User $user)
    {
        return $user->addresses;
    }

    public function create(User $user, array $data)
    {
        return $user->addresses()->create($data);
    }

    public function update(Address $address, array $data)
    {
        $address->update($data);

        return $address->fresh();
    }

    public function delete(Address $address)
    {
        $address->delete();
    }

    public function markAllAsNotDefault(User $user)
    {
        $user->addresses()->update(['is_default' => false]);
    }
}