<?php

namespace Modules\Notification\Jobs;

use App\Utils\DTO;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Notification\Models\Notification;
use Modules\Notification\Services\FirebaseService;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private DTO $dataObject)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(FirebaseService $service): void
    {
        if ($this->dataObject->send_type === 'single') {
            $this->sendSingleNotification($service);
        } else {
            $this->sendBulkNotification($service);
        }
    }

    private function sendSingleNotification(FirebaseService $service)
    {
        Notification::create([
            'user_id' => $this->dataObject->user_id,
            'title' => $this->dataObject->title,
            'body' => $this->dataObject->body,
            'is_read' => false,
            'notifiable_type' => $this->dataObject->notification_data['notifiable_type'] ?? null,
            'notifiable_id' => $this->dataObject->notification_data['notifiable_id'] ?? null,
        ]);
        if ($this->dataObject->fcm_token) {
            $service->sendToToken($this->dataObject->fcm_token, $this->dataObject->title, $this->dataObject->body, $this->dataObject->notification_data);
        }
    }

    private function sendBulkNotification(FirebaseService $service)
    {
        $data = $this->dataObject->notification_data;
        $title = $this->dataObject->title;
        $body = $this->dataObject->body;
        $tokens = $this->dataObject->fcm_tokens;

        if (!empty($tokens)) {
            Log::info('Sending bulk notification to tokens: ' . implode(', ', $tokens));
            $service->multiCast($tokens, $title, $body, $data);

            $placeholders = implode(',', array_fill(0, count($tokens), '?'));

            DB::insert("
                INSERT INTO notifications (user_id, title, body, is_read, notifiable_type, notifiable_id, created_at, updated_at)
                SELECT DISTINCT id, ?, ?, false, ?, ?, ?, ?
                FROM users
                WHERE fcm_token IN ($placeholders)
            ", array_merge([
                    $title,
                    $body,
                    $data['notifiable_type'] ?? null,
                    $data['notifiable_id'] ?? null,
                    now(),
                    now(),
                ], $tokens));
        }
    }
}