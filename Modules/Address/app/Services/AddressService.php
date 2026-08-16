<?php

namespace Modules\Address\Services;

use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Illuminate\Support\Facades\DB;
use Modules\Address\Models\Address;
use Modules\Address\Repositories\AddressRepository;

class AddressService
{
    public function __construct(private AddressRepository $addressRepository)
    {
    }

    public function index(User $user)
    {
        return $this->addressRepository->getUserAddresses($user);
    }

    public function create(DTO $dto)
    {
        $addresses = $this->addressRepository->getUserAddresses($dto->user);

        $is_default = false;
        if ($addresses->count() === 0) {
            $is_default = true;
        }

        $dto->append(['is_default' => $is_default]);

        return $this->addressRepository->create($dto->user, $dto->getData());
    }

    public function update(Address $address, DTO $dto)
    {
        if ($address->user_id !== $dto->user->id) {
            throw new BusinessException(message: __('message.address_not_found'), code: 404, errors: [__('message.address_not_found')]);
        }

        return DB::transaction(function () use ($dto, $address) {
            if ($dto->is_default) {
                $this->addressRepository->markAllAsNotDefault($dto->user);
            }
            return $this->addressRepository->update($address, $dto->getData());
        });
    }

    public function delete(Address $address, User $user)
    {
        if ($address->user_id !== $user->id) {
            throw new BusinessException(message: __('message.address_not_found'), code: 404, errors: [__('message.address_not_found')]);
        }

        $this->addressRepository->delete($address);
    }
}