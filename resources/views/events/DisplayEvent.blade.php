@extends('layouts.app')

@section('content')
<!-- Add ol.css manually -->
<link rel="stylesheet" href="{{ asset('css/ol.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<div class="container">
    <div class="card mb-3">
        <div class="card-header">
            <div class="header-left">
                {{ "Event Name: " . $event->name }}
            </div>
            <div class="header-right">
                {{ "Event Date: " . $event->date }}
            </div>
        </div>

        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    <div class="card my-3">
                        <div class="card-header">
                            {{ "All Invited Friends: " }}
                        </div>
                        <div class="card-body">
                            @if (!empty($friends))
                                @foreach ($friends as $friend)
                                    {{ $friend->username }}
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="container text-center my-3">
                        <div class="row justify-content-start">
                            <div class="col">
                                @include('components.mapComp')
                            </div>
                        </div>
                    </div>
                    {{ "Event Location: " . $event->address . ', ' . $event->zipcode . ' ' . $event->city }}
                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="row justify-content-start">
                <div class="col">
                    {{ "Current Recommended Date: " }}
                    @foreach ($recommended as $date)
                        {{ $date->start_date }}
                    @endforeach
                    @if ($event->owner_id == $user->id)
                    <form method="POST" action="{{ route('Recommended', ['id' => $event->id]) }}">
                        @csrf
                        @method('GET')
                        <div class="form-group mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Check recommended date</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection