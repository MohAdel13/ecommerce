<?php

namespace Modules\Ticket\Transformers;

use App\Http\Resources\EnumResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'status' => new EnumResource($this->status),
            'last_message' => $this->lastMessage ? new MessageResource($this->lastMessage) : null
        ];
    }
}