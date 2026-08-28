<?php

namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Notification\Http\Requests\CreateBulkNotificationRequest;
use Modules\Notification\Http\Requests\CreateNotificationRequest;
use Modules\Notification\Services\NotificationService;
use Modules\Notification\Transformers\NotificationResource;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private NotificationService $notificationService)
    {
    }

    public function index(PaginationRequest $request)
    {
        $dto = new DTO(['page' => $request->filled('page')]);

        $notifications = $this->notificationService->index($dto);

        $data = $request->filled('page') ? new PaginationCollection($notifications, 'notifications', NotificationResource::class) :
            NotificationResource::collection($notifications);

        return $this->success(data: $data);
    }

    public function myNotifications(PaginationRequest $request)
    {
        $dto = new DTO(['page' => $request->filled('page'), 'user_id' => Auth::user()->id]);

        $notifications = $this->notificationService->index($dto);

        $data = $request->filled('page') ? new PaginationCollection($notifications, 'notifications', NotificationResource::class) :
            NotificationResource::collection($notifications);

        return $this->success(data: $data);
    }

    public function sendNotification(CreateNotificationRequest $request)
    {
        $dto = DTO::FromRequest($request, ['fcm_token', 'title', 'body', 'notifiable_type', 'notifiable_id']);

        $this->notificationService->sendNotification($dto);

        return $this->success(data: []);
    }

    public function broadcastNotification(CreateBulkNotificationRequest $request)
    {
        $dto = DTO::FromRequest($request, ['title', 'notifiable_id', 'body', 'notifiable_type', 'tokens']);

        $this->notificationService->broadcastNotification($dto);

        return $this->success(data: []);
    }

    public function markAsRead()
    {
        $user = Auth::user()->load(['userNotifications']);
        $this->notificationService->setRead($user);

        return $this->success();
    }
}