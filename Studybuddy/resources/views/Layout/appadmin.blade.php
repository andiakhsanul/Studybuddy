<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Other head elements -->
    <meta property="og:image" itemprop="image" content="images/logoTitle/logoweb.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:wight" content="200">
    <meta property="og:image:height" content="200">
    <link rel="icon" type="image/png" href="images/logoTitle/logoweb.png">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('CSS/admin.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"
        integrity="sha384-pzjw8b+qU8HP2q4jslNXlePKotTNU5dhYlFfNf5R6hAeLv1d13Byq7wYLpd8pdsQ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyfFW73W/8f+kfTN2BOgdkH4MhXjstZ" crossorigin="anonymous"></script>
    <script src="{{ asset('orders.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title> {{ $title }} Dashboard Admin</title>
</head>

<body>
    @include('partials.adminsidebar')

    @yield('content')

    @include('partials.rightsidebar')
</body>

</html>
