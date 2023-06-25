@extends('layouts.app')
  @section('content')
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">User profile</div>

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
                    <button type="submit" class="btn btn-primary">Change username</button>
                  </div>
                </div>
              </form>

              <hr>

              <!-- update password -->
              <form method="POST" action="{{ route('profile.update.password') }}">
                @csrf
                @method('PUT')

                <div class="form-group row">
                  <label for="old-password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                  <div class="col-md-8">
                    <input id="old-password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="current-password">

                    @error('old_password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

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
                  <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>

                  <div class="col-md-8">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">Change password</button>
                  </div>
                </div>
              </form>

              <hr>

              <!-- upload profile picture -->
              <form method="POST" action="{{ route('profile.update.picture') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group row">
                  <label for="picture" class="col-md-4 col-form-label text-md-right">Profile Picture</label>

                  <div class="col-md-8">
                    <input id="picture" type="file" class="form-control-file @error('picture') is-invalid @enderror" name="picture" accept="image/*">

                    @error('picture')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">Upload Picture</button>
                  </div>
                </div>
              </form>

              <hr>
              
              <!-- show user id -->
              <div class="user-id" style="text-align: center;">
                User ID: <span class="user-id-number" style="font-weight: bold;">{{ $user->id }}</span>
                <p><i>Share your user-id with friends so they can find, add and invite you to event. Keep on creating memories!</i></p>
              </div>

              <hr>

              <!-- delete account button -->
              <form method="POST" action="{{ route('profile.delete') }}">
                @csrf
                @method('DELETE')

                <div class="form-group row mb-0">
                  <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">Verwijder account</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection