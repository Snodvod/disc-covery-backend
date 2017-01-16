<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="/img/logo.svg" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Ceviche+One|Nunito:400,900" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/jquery.fullPage.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/cbad98e1c7.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/jquery.fullPage.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/vendors/jquery.easings.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.2/vendors/scrolloverflow.min.js"></script>


</head>
<body>
<div class="container" id="fullpage">
    <div class="row fp-auto-height-responsive section homepage-hero-module" data-anchor="slide1">
        <div class="hero-unit">
            <h1>For the Record</h1>
            <h3>The social record player</h3>
            <p>
                Enjoy the warm sound of vinyl along with the perks of sharing your music with friends
            </p>
            <a href="#secondPage">
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            </a>
        </div>
        <div class="video-container">
            <video id="vi" autoplay loop class="fillWidth">
                <source src="vids/vibes.mp4" type="video/mp4"/>
                Your browser does not support the video tag. I suggest you upgrade your browser.
                <source src="vids/vibes.webm" type="video/webm"/>
                Your browser does not support the video tag. I suggest you upgrade your browser.
            </video>
            <div class="poster hidden">
                <img src="vids/vibes.jpg" alt="header video snapshot">
            </div>
        </div>

    </div>
    <div class="row fp-auto-height-responsive section" data-anchor="slide2">
        <div class="col-md-6 col-md-offset-3">
            <div class="row part">
                <div class="col-md-6">
                    <h3>What is For the Record?</h3>
                    <p>
                        For the Record is a project which endeavours to bring together the warm, full sound of vinyl
                        records
                        with the pleasure of sharing your music on social platforms like Spotify, Twitter and Facebook.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="logo"></div>
                </div>
            </div>
            <div class="row part">
                <div class="col-md-6">
                    <a class="" href="/download/android">
                        <div class="android">
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <h3>Download the companion app and start listening!</h3>
                    <p>
                        Although not available yet, we aim to release our revolutionary record player later this year,
                        along with the accompanying app.
                    </p>

                </div>
            </div>
            <div class="row part">
                <div class="col-md-6">
                    <h3>Any questions?</h3>
                    <p>We're ready for your questions! Hit us up:
                </div>
                <div class="col-md-6 contact">
                    <div class="row">
                        <div class="col-md-2"><a
                                    href="mailto:tim.vandijck.1@student.kdg.be, ino.vanwinckel@student.kdg.be"><i
                                        class="fa fa-envelope-o" aria-hidden="true"></i></a></div>
                        <div class="col-md-2"><a href="https://www.facebook.com/messages/InoVW"><i
                                        class="fa fa-facebook" aria-hidden="true"></i></a></p></div>
                        <div class="col-md-2"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="/js/app.js"></script>
</body>
</html>