@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Friends') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('here are your friends displayed') }}
                </div>
            <div class="card">
                    <div class="card-header">{{"Add Friends"}}</div>

                    <div class="card-body">
                        @foreach($users as $key => $value)
                            <div>{{$key}} : {{$value->name}} 
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
