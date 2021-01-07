@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <ul>
            @foreach ($chats as $chat)
                <li>
                    <a href="/chat/{{ $chat->chat_id}}">{{ $chat->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
