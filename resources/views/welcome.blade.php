<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <!-- main style sheet -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>

<body class="body-welcome">

  <div class="card">
    <div class="welcome-container">
      <h1 class="welcome-title">Welcome</h1>
      <div class="button-container">
        <a class="button login" href="/login">Login</a>
        <a class="button register" href="/register">Register</a>
      </div>
    </div>

</body>
</html>