<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class UserTicketsController extends Controller
{
    public function index($user_id, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::where('user_id', $user_id)->filter($filters)->paginate());
    }
}
