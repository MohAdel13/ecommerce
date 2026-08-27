<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Support\Facades\Auth;
use Modules\Ticket\Http\Requests\CreateMessageRequest;
use Modules\Ticket\Http\Requests\GetMessagesRequest;
use Modules\Ticket\Models\Message;
use Modules\Ticket\Services\MessageService;
use Modules\Ticket\Transformers\MessageResource;

class MessageController
{
    use ApiResponseTrait;

    public function __construct(
        protected MessageService $messageService,
    ) {
    }

    public function index(GetMessagesRequest $request)
    {
        $messages = $this->messageService->index($request->ticket_id, $request->filled('page'));

        $data = $request->filled('page') ? new PaginationCollection($messages, 'messages', MessageResource::class) :
            MessageResource::collection($messages);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateMessageRequest $request)
    {
        $dto = DTO::FromRequest($request, ['message', 'ticket_id'], Auth::user());

        $message = $this->messageService->send($dto);

        $data = new MessageResource($message);

        return $this->success(
            data: $data,
            message: __('message.message_created'),
        );
    }

    public function delete(Message $message)
    {
        $message = $this->messageService->delete($message);

        return $this->success(
            message: __('message.message_deleted'),
        );
    }
}