<?php

namespace Modules\Ticket\Services;

use App\Enums\TicketStatus;
use App\Models\User;
use App\Utils\DTO;
use Modules\Ticket\Models\Ticket;
use Modules\Ticket\Repositories\TicketRepository;

class TicketService
{
    public function __construct(
        protected TicketRepository $ticketRepository,
    ) {
    }

    public function index(DTO $dto)
    {
        return $dto->page ? $this->ticketRepository->getPaginated($dto) :
            $this->ticketRepository->getAll($dto);
    }

    public function create(DTO $dto)
    {
        $data = $dto->getData();

        $data['user_id'] = $dto->user->id;
        $data['status'] = TicketStatus::Open;

        return $this->ticketRepository->create($data);
    }

    public function update(Ticket $ticket, DTO $dto)
    {
        return $this->ticketRepository->update($ticket, $dto->getData());
    }

    public function delete(Ticket $ticket)
    {
        return $this->ticketRepository->delete($ticket);
    }
}