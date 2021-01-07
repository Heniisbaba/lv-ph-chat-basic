@extends('layouts.app')

@section('content')

<contain :user="'{{ Auth::user()->chat_id }}'" :sender="'{{ $sender->chat_id }}'"></contain>
@endsection
