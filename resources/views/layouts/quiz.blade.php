<html>
<head>
    <title>BQuizzer - @yield('title')</title>
    <link href="/css/app.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')

</head>
<body>


<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.html">BQuizzer - @yield('title')</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Page Header -->
<header class="masthead" style="background-image: url({{ $quiz->image_url ?: '/img/quiz-bg.jpg' }})">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    @section('top')
                    @show
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">

            </div>
        </div>
    </div>
</footer>

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script type="application/javascript">
    "use strict";
    var quizConf = {
        channelId: 'quiz-{!!  $quiz->id  !!}',
        teamId: '{{ $team->id }}',
        competition: @json($competition)
    }
</script>
@yield('script-vars')
<script src="/js/app.js"></script>
@yield('scripts')
</body>
</html>