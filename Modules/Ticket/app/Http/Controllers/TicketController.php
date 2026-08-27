<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Http\Requests\CreateTicketRequest;
use Modules\Ticket\Http\Requests\GetTicketsRequest;
use Modules\Ticket\Http\Requests\UpdateTicketRequest;
use Modules\Ticket\Models\Ticket;
use Modules\Ticket\Services\TicketService;
use Modules\Ticket\Transformers\TicketResource;

class TicketController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected TicketService $ticketService,
    ) {
    }

    public function index(GetTicketsRequest $request)
    {
        $dto = DTO::FromRequest($request, ['user_id', 'status']);
        $dto->append(['page' => $request->filled('page')]);

        $tickets = $this->ticketService->index($dto);

        $data = $request->filled('page') ? new PaginationCollection($tickets, 'tickets', TicketResource::class) :
            TicketResource::collection($tickets);

        return $this->success(
            data: $data,
        );
    }

    public function myTickets(GetTicketsRequest $request)
    {
        $dto = DTO::FromRequest($request, ['status']);
        $dto->append(['user_id' => Auth::user()->id, 'page' => $request->filled('page')]);

        $tickets = $this->ticketService->index($dto);

        $data = $request->filled('page') ? new PaginationCollection($tickets, 'tickets', TicketResource::class) :
            TicketResource::collection($tickets);

        return $this->success(
            data: $data,
        );
    }

    public function create(CreateTicketRequest $request)
    {
        $dto = DTO::FromRequest($request, ['subject'], Auth::user());

        $ticket = $this->ticketService->create($dto);

        $data = new TicketResource($ticket);

        return $this->success(
            data: $data,
            message: __('message.ticket_created'),
        );
    }

    public function show(Ticket $ticket)
    {
        $ticket = $ticket->fresh(['user', 'messages.user']);

        $data = new TicketResource($ticket);

        return $this->success(
            data: $data
        );
    }

    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        $dto = DTO::FromRequest($request, ['status']);
        $ticket = $this->ticketService->update($ticket, $dto);

        $data = new TicketResource($ticket);

        return $this->success(
            data: $data,
            message: __('message.ticket_updated')
        );
    }

    public function delete(Ticket $ticket)
    {
        $this->ticketService->delete($ticket);

        return $this->success(
            message: __('message.ticket_deleted')
        );
    }
}