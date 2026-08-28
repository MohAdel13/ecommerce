<?php

namespace Modules\Notification\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));

        $this->messaging = $factory->createMessaging();
    }

    public function sendToToken($token, $title, $body, $data = [])
    {
        $message = CloudMessage::new()->withToken($token)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        return $this->messaging->send($message);
    }

    public function multiCast($tokens, $title, $body, $data = [])
    {
        if (!$tokens) {
            return;
        }

        if (count($tokens) === 0) {
            return;
        }

        $message = CloudMessage::new()->withNotification(Notification::create($title, $body))
            ->withData($data);

        return $this->messaging->sendMulticast($message, $tokens);
    }
}