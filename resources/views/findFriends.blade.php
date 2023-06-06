@extends('layouts.app')

@section('content')

<style> 
.selected {
  background-color: #62d164;
}
.selectable-card {
    cursor: pointer;
}
</style>

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
                <div class="container">
                    <div class="row">
                        @foreach ($friends as $friend)
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body text-center align-middle selectable-card">
                                        <h3 class="card-title">{{ $friend->name }}</h3>
                                        <h5 class="card-content">{{ $friend->id }}</h5>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="selectedCards[]" class="selected-card" id="{{ $friend->id }}" value="{{ $friend->id }}">
                        @endforeach 
                    </div>
                </div>
                <button class="btn btn-primary mt-2" type="submit">{{ "Add friends" }}</button>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectable-card').click(function() {
            $(this).toggleClass('selected');

            // Get the IDs of all selected cards
            var selectedCardIDs = $('.selected-card').map(function() {
                return $(this).val();
            }).get();

            // Populate the hidden input field with the selected card IDs
            $('#selectedCards').val(selectedCardIDs.join(','));
        });
    });
</script>
@endsection
