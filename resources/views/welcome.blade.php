<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welkom</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <!-- main style sheet -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>

<body class="body-welcome">

  <div class="card">
    <div class="welcome-container">
      <h1 class="welcome-title">Welkom</h1>
      <div class="button-container">
        <a class="button login" href="/login">Aanmelden</a>
        <a class="button register" href="/register">Account aanmaken</a>
      </div>
    </div>

</body>
</html>