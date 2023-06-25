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

                    {{ __('Here are your friends displayed') }}
                    <br>
                    <br>

                    <div class="container">
                        <div class="row">
                            @foreach($usersArray as $friend)
                            <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                <div class="profile-picture-container d-flex justify-content-center align-items-center">
                                    @if($friend->profile_picture)
                                    <img src="{{ asset('storage/profile-pictures/' . $friend->profile_picture) }}" alt="Profile Picture" class="img-fluid rounded-circle friends-profile-picture">
                                    @else
                                    <img src="{{ asset('build/assets/images/default_avatar.png') }}" alt="Default Profile Picture" class="img-fluid rounded-circle friends-profile-picture">
                                    @endif
                                </div>
                                <h3 class="card-title">{{$friend->username}}</h3>
                                <h5 class="card-content">{{"id: ". $friend->id}}</h5>
                                </div>
                            </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">{{"Add Friends"}}</div>
                <div class="card-body">
                    <a type="button" class="btn btn-primary" href="{{route('searchFriends')}}">{{"Search"}}</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{"Delete Friends"}}</div>
                <div class="card-body">
                    <a type="button" class="btn btn-primary" href="{{route('findFriends')}}">{{"Search"}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
