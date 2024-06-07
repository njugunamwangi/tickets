<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserTicketsController extends ApiController
{
    public function index($user_id, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::where('user_id', $user_id)->filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($user_id, StoreTicketRequest $request)
    {

        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $user_id,
        ];

        return new TicketResource(Ticket::create($model));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $ticketId)
    {
        try {

            $ticket = Ticket::findOrFail($ticketId);

            if($ticket->user_id == $userId) {

                $ticket->delete();

                return $this->ok('Ticket deleted successfully');
            }

        } catch(ModelNotFoundException $exception) {

            return $this->ok('Ticket not found', 404);
        }
    }
}
