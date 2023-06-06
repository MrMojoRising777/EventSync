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
                    <br>
                    <br>
                    
                    <div class="container">
                        <div class="row">
                    @foreach($usersArray as $friend)

                          <div class="col-md-3">
                            <div class="card mb-4">
                              <div class="card-body text-center align-middle">
                                <h3 class="card-title">{{$friend->name}}</h3>
                                <h5 class="card-content">{{"id: ". $friend->id}}</h5>
                              </div>
                            </div>
                          </div>
                        
                    @endforeach
                        </div>
                    </div>
                </div>
            <div class="card">
                    <div class="card-header">{{"Add Friends"}}</div>

                    <div class="card-body">
                        <a type="button" class="btn btn-primary" href="{{route('findFriends')}}">{{"Search"}}</a>
                        
                        
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
