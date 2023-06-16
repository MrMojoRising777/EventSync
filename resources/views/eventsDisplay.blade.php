@extends('layouts.app')

@section('content')


@foreach ($events as $event)
                        <div class="col-md-4">

                            <div class="card" style="width: 18rem;">
                                <div class="card-header">
                                  {{$event->event_name}}
                                </div>
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item"> {{$event->date}}</li>
                                </ul>
                            </div>
                        
                        </div>
                        @endforeach 

@endsection