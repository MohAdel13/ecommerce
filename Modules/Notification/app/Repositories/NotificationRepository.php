<?php

namespace Modules\Notification\Repositories;

use App\Models\User;
use App\Utils\DTO;
use Modules\Notification\Models\Notification;

class NotificationRepository
{
    public function getPaginatedNotifications(DTO $dto)
    {
        return $this->notificationsQuery($dto)->paginate(15, ['*'], 'page');
    }

    public function getAllNotifications(DTO $dto)
    {
        return $this->notificationsQuery($dto)->get();
    }

    public function notificationsQuery(DTO $dto)
    {
        return Notification::query()->with(['user', 'notifiable'])
            ->when(
                $dto->user_id,
                fn($q) => $q->where('user_id', $dto->user_id)
            )->latest();
    }

    public function MarkMyNotificationsAsRead(User $user)
    {
        $user->userNotifications()->where('is_read', false)->update(['is_read' => true]);
    }

    public function findUserByFcmToken(string $fcm_token)
    {
        return User::where('fcm_token', $fcm_token)?->first();
    }

    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }
}