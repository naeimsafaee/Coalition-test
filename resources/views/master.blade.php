<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test project</title>
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

</head>
<body>


@yield('content')

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

@yield('script')

</body>
</html>
