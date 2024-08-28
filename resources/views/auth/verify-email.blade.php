<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Required</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-warning">
            <h4 class="alert-heading">Email Verification Required</h4>
            <p>Please verify your email address to access this feature.</p>
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <p>If you did not receive the verification email, click the button below to resend it.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script> <!-- Include your JS file -->
</body>
</html>
