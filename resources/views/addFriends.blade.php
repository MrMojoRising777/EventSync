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


  
  <style>
    .checkbox-wrapper-16 *,
    .checkbox-wrapper-16 *:after,
    .checkbox-wrapper-16 *:before {
      box-sizing: border-box;
    }
  
    .checkbox-wrapper-16 .checkbox-input {
      clip: rect(0 0 0 0);
      -webkit-clip-path: inset(100%);
              clip-path: inset(100%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap;
      width: 1px;
    }
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile {
      border-color: #2260ff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile:before {
      transform: scale(1);
      opacity: 1;
      background-color: #2260ff;
      border-color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-icon,
    .checkbox-wrapper-16 .checkbox-input:checked + .checkbox-tile .checkbox-label {
      color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile {
      border-color: #2260ff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
    }
    .checkbox-wrapper-16 .checkbox-input:focus + .checkbox-tile:before {
      transform: scale(1);
      opacity: 1;
    }
  
    .checkbox-wrapper-16 .checkbox-tile {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 7rem;
      min-height: 7rem;
      border-radius: 0.5rem;
      border: 2px solid #b5bfd9;
      background-color: #fff;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      transition: 0.15s ease;
      cursor: pointer;
      position: relative;
    }
    .checkbox-wrapper-16 .checkbox-tile:before {
      content: "";
      position: absolute;
      display: block;
      width: 1.25rem;
      height: 1.25rem;
      border: 2px solid #b5bfd9;
      background-color: #fff;
      border-radius: 50%;
      top: 0.25rem;
      left: 0.25rem;
      opacity: 0;
      transform: scale(0);
      transition: 0.25s ease;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
      background-size: 12px;
      background-repeat: no-repeat;
      background-position: 50% 50%;
    }
    .checkbox-wrapper-16 .checkbox-tile:hover {
      border-color: #2260ff;
    }
    .checkbox-wrapper-16 .checkbox-tile:hover:before {
      transform: scale(1);
      opacity: 1;
    }
  
    .checkbox-wrapper-16 .checkbox-icon {
      transition: 0.375s ease;
      color: #494949;
    }
    .checkbox-wrapper-16 .checkbox-icon svg {
      width: 3rem;
      height: 3rem;
    }
  
    .checkbox-wrapper-16 .checkbox-label {
      color: #707070;
      transition: 0.375s ease;
      text-align: center;
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
                        <div class="checkbox-wrapper-16">
                            <label class="checkbox-wrapper">
                              <input type="checkbox" class="checkbox-input" name="selectedItems[]" value="{{$friend->id}}" />
                                <span class="checkbox-tile text-center align-middle">
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


