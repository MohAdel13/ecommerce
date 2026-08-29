<?php

namespace Modules\Home\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Home\Services\HomeService;

class HomeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private HomeService $homeService
    ) {
    }

    public function index(Request $request)
    {
        $user = $request->user('sanctum');

        if ($user) {
            Auth::setUser($user);
        }

        return $this->success(
            data: $this->homeService->index($user)
        );
    }
}