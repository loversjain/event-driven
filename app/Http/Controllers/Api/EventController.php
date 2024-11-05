<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserEventRequest;
use App\Events\UserEvent;

class EventController extends Controller
{
    public function handleUserEvent(UserEventRequest $request)  {
        UserEvent::dispatch(
            $request->userId, 
            $request->eventType, 
            $request->metaData
        );
        return response()->json(["status" => "Event created", "status_code" => 200]);
    }
}
