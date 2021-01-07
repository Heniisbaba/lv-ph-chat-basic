<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\MessagesResource;
use Illuminate\Http\Request;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = User::all(['chat_id','name'])->except(Auth::id());
        return view('chats', compact('chats'));
    }
    /**
     * Show single chat
     *
     * @param string $sender
     * @return \Illuminate\Http\Response
     */
    public function single($sender)
    {
        $sender = User::whereChat_id($sender)->first();
        return view('chat', compact('sender'));
    }

    /**
     * Fetch all messages
     *
     * @param $string $sender
     * @return Message
     */
    public function fetchMessages($sender)
    {
        $msg = Message::with('sender')->where('user_id',$sender)->orWhere('receiver_id',$sender)->get();

        return new MessagesResource($msg);
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @param  $string $receiver
     * @return Response
     */
    public function sendMessage(Request $request,$receiver)
    {
        $user = Auth::user();

        $message = Message::create([
            'user_id' => $user->chat_id,
            'message' => $request->input('message'),
            'receiver_id' => $receiver
        ]);

        broadcast(new \App\Events\MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!', 'data' => new \App\Http\Resources\MessageResource($message)];
    }
}
