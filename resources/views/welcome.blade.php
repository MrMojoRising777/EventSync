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
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background-color: #f3f4f6;
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
      background-color: #ef4444;
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
  </style>
</head>
<body>
  <div class="container">
    <h1 class="title">Welkom</h1>
    <div class="button-container">
      <a class="button" href="/login">Aanmelden</a>
      <a class="button" href="/register">Account aanmaken</a>
    </div>
  </div>
</body>
</html>