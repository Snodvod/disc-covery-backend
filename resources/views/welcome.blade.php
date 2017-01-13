<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Ceviche+One|Nunito:400,900" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh; color: #fff; font-family: 'Nunito', sans-serif;
            background: url('../img/background.jpg'); background-attachment: fixed; background-size: cover;
        }
        .navbar {
            background: url('../img/wood.jpg'); background-position: center; background-repeat: repeat-x ; border: none;
        }
        .navbar-default .navbar-brand { color: #fff; font-family: 'Ceviche One', cursive; font-size: 2em }
        .navbar-default .navbar-brand:hover { color: #ccc; }
        .hero-unit {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto; z-index: 1;
            width: 40%; height: 10em; font-size: 1.5em;
        }
        .hero-unit h1 { font-size: 2em; }

        .homepage-hero-module { margin-top: -22px; height: calc(100vh - 50px); position: relative; }
        .homepage-hero-module .video-container { height: 100%; overflow: hidden; }
        .homepage-hero-module .video-container video { margin-top: -20em; }
        #logo { height: 1em; margin: -7px 10px; float: left; }
        h1, h2, h3 { font-weight: 900;}
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img id="logo" src="img/logo.svg" alt="{{ config('app.name', 'Laravel') }}"> {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

                </ul>
            </div>
        </div>
    </nav>
    <div class="homepage-hero-module">
        <div class="hero-unit">
            <h1>The social record player</h1>
            <p>
                Enjoy the warm sound of vinyl along with the perks of sharing your music with friends
            </p>
        </div>
        <div class="video-container">
            <div class="filter"></div>
            <video autoplay loop class="fillWidth">
                <source src="vids/vibes.mp4" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.
                <source src="vids/vibes.webm" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.
            </video>
            <div class="poster hidden">
                <img src="vids/vibes.jpg" alt="header video snapshot">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>What is For the Record?</h3>
                <p>
                    For the Record is a project which envdeavours to bring together the warm, full sound of vinyl records
                    with the pleasure of sharing your music on social palforms like Spotify, Twitter and Facebook.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>How do mere mortals procure such a  thing?</h3>
                <p>
                    Although not available yet, we aim to release our revolutionary record player later this year,
                    along with the accompanying app.
                </p>
                <div class="row">
                    <div class="col-md-2 col-md-offset-3"><a href="#" class="btn btn-primary">Play Store</a></div>
                    <div class="col-md-2 col-offset-2"><a href="#" class="btn btn-secondary">App Store</a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h3>Any questions?</h3>
                <p>We're ready for your questions! Hit us up <a href="mailto:tim.vandijck.1@student.kdg.be, ino.vanwinckel@student.kdg.be">via e-mail</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>