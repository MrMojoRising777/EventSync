<!-- profile/show.blade.php -->

@extends('layouts.app')

@section('styles')
  <style>
    .form-group {
      margin-bottom: 20px;
    }

    .card-header {
      font-weight: bold;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      margin-bottom: 0.5em;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
    }

    .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">User Profile</div>

          <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            <!-- update username -->
            <form method="POST" action="{{ route('profile.update.username') }}">
              @csrf
              @method('PUT')

              <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                <div class="col-md-8">
                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autofocus>

                  @error('username')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-4">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Update Username</button>
                </div>
              </div>
            </form>

            <hr>

            <!-- update password -->
            <form method="POST" action="{{ route('profile.update.password') }}">
              @csrf
              @method('PUT')

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-8">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                <div class="col-md-8">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
              </div>

              <div class="form-group row mb-4">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
              </div>
            </form>

            <hr>

            <form method="POST" action="{{ route('profile.delete') }}">
              @csrf
              @method('DELETE')

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection