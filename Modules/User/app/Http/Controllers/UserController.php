<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnumResource;
use App\Http\Resources\PaginationCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\GetUsersRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private UserService $userService)
    {
    }
    public function index(GetUsersRequest $request)
    {
        $dto = DTO::FromRequest($request, ['role', 'search']);
        $dto->append(['page' => $request->filled('page')]);

        $users = $this->userService->index($dto);

        $data = $request->filled('page') ? new PaginationCollection($users, 'users', UserResource::class) :
            UserResource::collection($users);

        return $this->success(
            data: $data
        );
    }

    public function show(User $user)
    {
        $data = new UserResource($user);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateUserRequest $request)
    {
        $dto = DTO::FromRequest($request, [
            'name',
            'email',
            'phone',
            'password',
            'role'
        ]);

        $user = $this->userService->create($dto);

        $data = new UserResource($user);

        return $this->success(
            data: $data,
            message: __('message.user_created')
        );
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        $dto = DTO::FromRequest($request, [
            'name',
            'email',
            'phone',
            'role'
        ]);

        $user = $this->userService->update($user, $dto);

        $data = new UserResource($user);

        return $this->success(
            data: $data,
            message: __('message.user_updated')
        );
    }

    public function delete(User $user)
    {
        $this->userService->delete($user);

        return $this->success(
            message: __('message.user_deleted')
        );
    }

    public function getRoles()
    {
        $roles = $this->userService->getRoles();

        $data = EnumResource::collection($roles);

        return $this->success(
            data: $data
        );
    }
}