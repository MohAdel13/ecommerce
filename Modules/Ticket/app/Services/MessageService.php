<?php

namespace Modules\Ticket\Services;

use App\Events\MessageSent;
use App\Utils\DTO;
use Modules\Ticket\Models\Message;
use Modules\Ticket\Repositories\MessageRepository;

class MessageService
{
    public function __construct(
        protected MessageRepository $messageRepository,
    ) {
    }

    public function send(DTO $dto)
    {
        $data = $dto->getData();
        $data['sender_id'] = $dto->user->id;
        $data['sender_type'] = $dto->user->role;

        $message = $this->messageRepository->create($data);

        event(new MessageSent($message));

        return $message;
    }

    public function index(?int $ticket_id, ?bool $page)
    {
        return $page ? $this->messageRepository->getPaginated($ticket_id) :
            $this->messageRepository->getAll($ticket_id);
    }

    public function delete(Message $message)
    {
        return $this->messageRepository->delete($message);
    }
}