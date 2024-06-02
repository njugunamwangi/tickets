<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when($request->routeIs('tickets.show'), $this->description),
                'status' => $this->status,
                'created_at' => $this->created_at->toDateString(),
                'updated_at' => $this->updated_at->toDateString(),
            ],
            'links' => [
                'self' => route('tickets.show', ['ticket' => $this->id])
            ],
            'includes' => new UserResource($this->whenLoaded('user')),
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id
                    ],
                    'links' => [
                        'self' => route('users.show', ['user' => $this->user_id])
                    ]
                ]
            ]
        ];
    }
}
