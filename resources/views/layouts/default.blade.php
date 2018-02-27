<html>
<head>
    <title>BQuizzer - @yield('title')</title>
    <link href="/css/app.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="flex-center position-ref full-height">

    <!-- Page Content -->
    <div class="container">
        @section('top')

        @show


        <div class="content">
            @yield('content')
        </div>
    </div>


</div>

<script src="/js/app.js"></script>
</body>
</html>