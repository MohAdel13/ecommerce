<?php

namespace Modules\Ticket\Repositories;

use App\Utils\DTO;
use Modules\Ticket\Models\Ticket;

class TicketRepository
{
    public function getAll(DTO $dto)
    {
        return $this->query($dto)->get();
    }

    public function getPaginated(DTO $dto)
    {
        return $this->query($dto)->paginate(15, ['*'], 'page');
    }

    public function query(DTO $dto)
    {
        return Ticket::query()->with(['user', 'messages.user'])
            ->when(
                $dto->user_id,
                fn($q) => $q->where('user_id', $dto->user_id)
            )->when(
                $dto->status,
                fn($q) => $q->where('status', $dto->status)
            )->latest();
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update(Ticket $ticket, array $data)
    {
        $ticket->update($data);

        return $ticket->fresh(['user', 'messages.user']);
    }

    public function delete(Ticket $ticket)
    {
        return $ticket->delete();
    }
}