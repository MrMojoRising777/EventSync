<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
    
    <style>
        /* email */
        .footer-email {
            background: rgb(255, 165, 0);
            background: linear-gradient(45deg, rgba(255, 165, 0, 1) 0%, rgba(254, 152, 24, 1) 35%, rgba(252, 139, 48, 1) 100%);
            color: white;
            text-align: center;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .logo-email {
            height: 100px;
            width: 150px;
        }

        .footer-text {
            flex: 1;
            margin-left: 20px;
            text-align: right;
        }

        .footer-text p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>

    <p>{!! $details['body'] !!}</p>

    <footer class="footer-email"> 
        <img src="https://i.imgur.com/Sg29RJo.png" alt="Logo" class="logo-email">
        <div class="footer-text">
            <p class="mb-1">&copy; {{ date('Y') }} EventSync. All rights reserved.</p>
            <p class="mb-1">Thor Park 8300, 3600 Genk, Belgium</p>
            <p class="mb-0">Email: eventsync.mail@gmail.com</p>
        </div>
    </footer>
</body>
</html>