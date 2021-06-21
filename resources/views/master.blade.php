<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Vue.js ACL</title>
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}" />
</head>

<body class="skin-default-dark fixed-layout">
    <div id="app">
        <main-app :user="{{Auth::guard('admin')->user()}}" :role="{{Auth::guard('admin')->user()->roles[0]}}" :resources="{{Auth::guard('admin')->user()->resources}}" :permissions="{{Auth::guard('admin')->user()->permissions}}"></main-app>
    </div>

    <script type="text/javascript" src="{{ mix('js/front.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/main.js') }}"></script>
    {!! Toastr::message() !!}
</body>
</html>