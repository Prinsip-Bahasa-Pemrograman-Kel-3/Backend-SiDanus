<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Events\TestBroadcastEvent;

class testBroadcast extends Controller
{
    public function broadcastMessage(Request $request)
    {
        $message = $request->input('message', 'Default test message');

        // Trigger event broadcast
        broadcast(new TestBroadcastEvent($message));

        return response()->json(['status' => 'Message broadcasted!', 'message' => $message]);
    }
}
