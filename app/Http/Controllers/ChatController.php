<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function getReceiver(User $receiver){
        $getRoom = Room::where([
            ['sender','=',auth()->user()->id],
            ['receiver','=',$receiver->id]
        ])->orWhere([
            ['sender','=',$receiver->id],
            ['receiver','=',auth()->user()->id]
        ])->first();
        if($getRoom){
            $roomId = $getRoom->roomId;
            return view('chat',compact('receiver','roomId'));
        }else{
            $roomId = Str::random(10);
            $room = Room::create([
                'roomId' => $roomId,
                'sender' => auth()->user()->id,
                'receiver' => $receiver->id
            ]);
            return view('chat',compact('receiver','roomId'));
        }
    }
    public function sendMessage(User $receiver,Request $request){
        $message = Message::create([
            'sender' => auth()->user()->id,
            'receiver' => $receiver->id,
            'message' => $request['message']
        ]);
        broadcast(new ChatSent($message,$request['roomId']))->toOthers();
    }
}
