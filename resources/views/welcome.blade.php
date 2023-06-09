<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welkom</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <!-- Styles -->
  <style>
    body {
      font-family: 'Figtree', sans-serif;
      background-color: #f7fafc;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .card {
      max-width: 500px;
      padding: 2rem;
      background-color: #ffffff;
      border-radius: 0.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .title {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .button-container {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1rem;
    }

    .button {
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      color: white;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      text-align: center;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #dc2626;
    }
    .button.register {
      background-color: #ff5722;
    }

    .button.login {
      background-color: #4caf50;
    }

    .button.register:hover {
      background-color: #ff7847;
    }

    .button.login:hover {
      background-color: #4dbf77;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1 class="title">Welkom</h1>
    <div class="button-container">
      <a class="button login" href="/login">Aanmelden</a>
      <a class="button register" href="/register">Account aanmaken</a>
    </div>
  </div>
</body>
</html>