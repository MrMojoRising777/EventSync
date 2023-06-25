@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('searchFriends') }}" method="POST">
                @csrf
                <input type="text" id="search" name="search" class="form-control" placeholder="Search a friend using 'username' or their 'id'">
                <button class="btn btn-primary mt-2" type="submit">Search</button>
            </form>
        </div>
    </div>
    <br>
    <div class="row justify-content-start flex-wrap">
        <div class="col-md-4">
            <form action="{{ route('AddFriends') }}" method="POST">
                @csrf
                <div class="addfriends-container row">
                    @foreach ($friends as $friend)
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="checkbox-wrapper-16">
                            <label class="checkbox-wrapper d-flex align-items-center">
                                <input type="checkbox" class="checkbox-input" name="selectedItems[]" value="{{$friend->id}}" />
                                <span class="checkbox-tile text-center align-middle">
                                    <div class="profile-picture-container d-flex justify-content-center align-items-center">
                                        @if($friend->profile_picture)
                                        <img src="{{ asset('storage/profile-pictures/' . $friend->profile_picture) }}" alt="Profile Picture" class="img-fluid rounded-circle friends-profile-picture">
                                        @else
                                        <img src="{{ asset('build/assets/images/default_avatar.png') }}" alt="Default Profile Picture" class="img-fluid rounded-circle friends-profile-picture">
                                        @endif
                                    </div>
                                    <br>
                                    {{$friend->username}}
                                    <br>
                                    {{$friend->id}}                           
                                </span>                                
                            </label>
                        </div>
                    </div>
                    @endforeach 
                </div>
                <button class="btn btn-primary mt-2" type="submit">{{ "Add friends" }}</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Add event listeners to checkboxes - Always use plain vanilla JS - no JQUERY!!
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            this.parentNode.classList.toggle('selected', this.checked);
        });
    });
</script>
@endsection


