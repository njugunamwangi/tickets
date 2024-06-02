<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if($this->include('author')) {
            $tickets = Ticket::with('user')->paginate();
        }

        $tickets = Ticket::paginate();

        return TicketResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        if($this->include('author')) {
            $ticket = $ticket->load('user');
        }

        return new TicketResource($ticket);
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
    public function destroy(Ticket $ticket)
    {
        //
    }
}
