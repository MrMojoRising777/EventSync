@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-header">
           {{"Event Name: " . $event->name}}
        </div>

        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    {{"event date: " . $event->date}}
                </div>
                <div class="col">
                    {{"event location: " . $event->address . ', ' . $event->zipcode . ' ' . $event->city}}
                </div>
            </div>
        </div>

        <hr>
    
        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    @if ($event->owner_id == $user->id)
                    <form method="POST" action="{{route('Recommended', ['id' => $event->id])}}">
                        @csrf
                        @method('GET')
                        <div class="form-group">
                          <div class="col">
                            <button type="submit" class="btn btn-success">Check recommended date</button>
                          </div>
                        </div>
                      </form>
                    @endif
                    {{"Current Reccomended Date: "}}
                    @foreach ($recommended as $date)
                        {{$date->start_date}}
                    @endforeach

                </div>
            </div>
        </div>



        <hr>
    
        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    {{"all invited Friends: "}}
                    @if (!empty ($friends))
                        @foreach ($friends as $friend)
                            {{$friend->username}}
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <hr>
    
        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    {{"map"}}
                </div>
            </div>
        </div>

@endsection