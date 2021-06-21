<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Laravel Vue ACL Panel | @yield('title')</title>
    <link href="{{ mix('css/auth.css') }}" rel="stylesheet">
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    <style>
        .auth_body {
            /* background-image: linear-gradient(to right top, #928bb2, #8174bb, #6f5dc3, #5b44c9, #4326ce); */
            /* background-image: linear-gradient(to right top, #ada3db, #9b8be1, #8873e7, #745aea, #5d3eed); */
            background-image: linear-gradient(to right top, #b7afb3, #baa9b7, #b8a4be, #afa1c8, #9ea0d3, #89a2d9, #6da4dc, #49a7dc, #1eaad3, #00acc6, #00acb5, #18aca2);
        }
    </style>
</head>

<!-- <body class="skin-default card-no-border"> -->
<body class="auth_body">
    <section id="wrapper">
        @yield('content')
    </section>
    <script src="{{ mix('js/auth.js') }}"></script>
    {!! Toastr::message() !!}
</body>

</html>