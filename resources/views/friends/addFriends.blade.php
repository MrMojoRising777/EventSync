@extends('layouts.app')

@section('content')
<div class="container mb-3">
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('searchFriends') }}" method="POST">
                @csrf
                <input type="text" id="search" name="search" class="form-control" placeholder="Zoek een vriend">
                <button class="btn btn-primary mt-2" type="submit">Zoek</button>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('AddFriends') }}" method="POST">
                @csrf
                <div class="addfriends-container">
                    <div class="row justify-content-start flex-wrap">
                        @foreach ($friends as $friend)
                        <div class="col-md-4 col-sm-6 col-12 mb-3">
                            <div class="checkbox-wrapper-16">
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" class="checkbox-input" name="selectedItems[]" value="{{$friend->id}}" />
                                    <span class="checkbox-tile text-center align-middle">
                                        {{$friend->username}}
                                        <br>
                                        {{$friend->id}}                           
                                    </span>                                
                                </label>
                            </div>
                        </div>
                        @endforeach 
                    </div>
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

