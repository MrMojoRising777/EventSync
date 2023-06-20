@extends('layouts.app')

@section('content')

{{$event->name}}
<hr>
{{$event->date}}
<hr>
{{"all invited Friends"}}
<hr>
    @if (!empty ($users))
        @foreach ($users as $user)
            {{$user->username}}
        @endforeach
    @endif
@endsection