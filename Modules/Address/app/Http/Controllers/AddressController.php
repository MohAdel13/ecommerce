<?php

namespace Modules\Address\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Http\Requests\CreateAddressRequest;
use Modules\Address\Http\Requests\UpdateAddressRequest;
use Modules\Address\Models\Address;
use Modules\Address\Services\AddressService;
use Modules\Address\Transformers\AddressResource;

class AddressController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AddressService $addressService)
    {
    }

    public function show(Address $address)
    {
        if ($address->user_id !== request()->user()->id) {
            throw new BusinessException(message: __('message.address_not_found'), code: 404, errors: [__('message.address_not_found')]);
        }

        $data = new AddressResource($address);

        return $this->success(
            data: $data
        );
    }

    public function index()
    {
        $addresses = $this->addressService->index(Auth::user());

        $data = AddressResource::collection($addresses);

        return $this->success(data: $data);
    }

    public function create(CreateAddressRequest $request)
    {
        $dto = DTO::FromRequest(
            $request,
            [
                'name',
                'phone',
                'address_name',
                'address_line',
                'lat',
                'lng',
                'note'
            ],
            Auth::user()
        );

        $address = $this->addressService->create($dto);

        $data = new AddressResource($address);

        return $this->success(message: __('message.address_created'), data: $data);
    }

    public function update(Address $address, UpdateAddressRequest $request)
    {
        $dto = DTO::FromRequest(
            $request,
            [
                'name',
                'phone',
                'address_name',
                'address_line',
                'lat',
                'lng',
                'note',
                'is_default'
            ],
            Auth::user()
        );

        $address = $this->addressService->update($address, $dto);

        $data = new AddressResource($address);

        return $this->success(message: __('message.address_updated'), data: $data);
    }

    public function delete(Address $address)
    {
        $this->addressService->delete($address, Auth::user());

        return $this->success(message: __('message.address_deleted'), data: []);
    }
}