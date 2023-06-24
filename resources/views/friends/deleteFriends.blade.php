@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('DeleteFriends') }}" method="POST">
                @csrf
                <div class="deletefriends-container">
                    <div class="row justify-content-start flex-wrap">
                        @foreach ($usersArray as $friend)
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="checkbox-wrapper-16">
                            <label class="checkbox-wrapper">
                              <input type="checkbox" class="checkbox-input" name="selectedItems[]" value="{{$friend->id}}" />
                                <span class="checkbox-tile text-center align-middle">
                                    <div class="profile-picture-container d-flex justify-content-center align-items-center">
                                        @if($friend->profile_picture)
                                        <img src="{{ $friend->profile_picture }}" alt="Profile Picture" class="img-fluid rounded-circle friends-profile-picture">
                                        @else
                                        <img src="{{ asset('build/assets/images/default_avatar.png') }}" alt="Default Profile Picture" class="img-fluid rounded-circle friends-profile-picture">
                                        @endif
                                    </div>
                                    <br>
                                    {{$friend->username}}
                                    <br>
                                    {{$friend->id}}                           
                                </span>                                
                              </span>
                            </label>
                          </div>
                        </div>
                        @endforeach 
                    </div>
                </div>
                <button class="btn btn-primary mt-2" type="submit">{{ "Delete friend(s)" }}</button>
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


