<?php

namespace Modules\Notification\Services;

use App\Models\User;
use App\Utils\DTO;
use Modules\Notification\Jobs\SendNotificationJob;
use Modules\Notification\Repositories\NotificationRepository;

class NotificationService
{
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }

    public function index(DTO $dto)
    {
        return $dto->page ? $this->notificationRepository->getPaginatedNotifications($dto) :
            $this->notificationRepository->getAllNotifications($dto);
    }

    public function sendNotification(DTO $dto)
    {
        $notifiable_id = $dto->notifiable_id;
        $notifiable_type = $dto->notifiable_type;

        $data = ['notifiable_id' => (string) $notifiable_id, 'notifiable_type' => (string) $notifiable_type];
        if (!($notifiable_id && $notifiable_type)) {
            $data = [];
        }

        $dto->append([
            'notification_data' => $data,
            'send_type' => 'single',
        ]);

        if (!$dto->user_id) {
            $user = $this->notificationRepository->findUserByFcmToken($dto->fcm_token);
            $dto->append([
                'user_id' => $user->id,
            ]);
        }

        SendNotificationJob::dispatch($dto);
    }

    public function broadcastNotification(DTO $dto)
    {
        $notifiable_id = $dto->notifiable_id;
        $notifiable_type = $dto->notifiable_type;

        $data = ['notifiable_id' => (string) $notifiable_id, 'notifiable_type' => (string) $notifiable_type];
        if (!($notifiable_id && $notifiable_type)) {
            $data = [];
        }

        $dto->append([
            'notification_data' => $data,
            'send_type' => 'broadcast',
        ]);


        $tokens = array_unique($dto->tokens);
        $dto->append(['fcm_tokens' => $tokens]);

        SendNotificationJob::dispatch($dto);
    }

    public function setRead(User $user)
    {
        $this->notificationRepository->MarkMyNotificationsAsRead($user);
    }
}