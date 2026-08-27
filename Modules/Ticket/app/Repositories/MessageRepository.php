<?php

namespace Modules\Ticket\Repositories;

use Modules\Ticket\Models\Message;

class MessageRepository
{
    public function create(array $data)
    {
        $message = Message::create($data);

        return $message->fresh(['user', 'ticket.user']);
    }

    public function getAll(?int $ticket_id = null)
    {
        return $this->query($ticket_id)->get();
    }

    public function getPaginated(?int $ticket_id = null)
    {
        return $this->query($ticket_id)->paginate(15, ['*'], 'page');
    }

    public function query(?int $ticket_id = null)
    {
        return Message::query()->with(['user', 'ticket.user'])
            ->when(
                $ticket_id,
                fn($q) => $q->where('ticket_id', $ticket_id)
            )->latest();
    }

    public function delete(Message $message)
    {
        return $message->delete();
    }
}