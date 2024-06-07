<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {

            $user = User::findOrFail($request->input('data.relationships.user.data.id'));
        } catch(ModelNotFoundException $exception) {

            return $this->ok('User not found', [
                'error' => 'User id not found'
            ]);
        }

        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.user.data.id'),
        ];

        return new TicketResource(Ticket::create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show($ticketId)
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            $ticket = $this->include('author') ? $ticket->load('user') : $ticket;

            return new TicketResource($ticket);

        } catch(ModelNotFoundException $exception) {

            return $this->ok('Ticket not found', 404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticketId)
    {
        try {

            $ticket = Ticket::findOrFail($ticketId);

            $ticket->delete();

            return $this->ok('Ticket deleted successfully');

        } catch(ModelNotFoundException $exception) {

            return $this->ok('Ticket not found', 404);
        }
    }
}
