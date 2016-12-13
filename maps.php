<!DOCTYPE HTML>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>GoPortlethen - Maps</title>

    <meta name="description" content="GoPortlethen - Maps"/>
    <link rel="shortcut icon" href="faviconlinkhere" type="image/png"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>

    <!-- Style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/main.css" type="text/css" />
    <link rel="stylesheet" href="../css/orange.css" type="text/css" />
</head>

<!-- Navigation include -->
<?php include 'elements/header.php'; ?>

<div id="content">
    <section id="register">
        <div class="container">
            <div class="row">
                <div
                    class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 md-margin-top">
                    <div class="page-subheader text-center">
                        <h1>Mapping</h1>
                        <hr/>
                        <p>Different places of interest around Portlethen and surround areas!</p>
                    </div>
                </div>

                <div class="row">

                    <div id="map"></div>
                    <script>
                        var map;
                        function initMap() {
                            map = new google.maps.Map(document.getElementById('map'), {
                                center: {lat: 57.0577505, lng: -2.1381166},
                                zoom: 10
                            });
                        }
                    </script>

                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHX9LYCWwlXx11JVOIXJakp5u-LetMNPo&callback=initMap"></script>

                    <div class="row"></div><button class="btn btn-default" onclick="location1()">Portlethen Train Station</button></div>

                    <script>
                        function location1(){
                            map = new google.maps.Map(document.getElementById('map'), {
                                center: {lat: 57.0615139, lng: -2.1980521},
                                zoom: 15,})
                        }
                    </script>
                </div>

                </div>
                <!-- Row / END -->
            </div>
            <!-- Container / END -->
        </div>
    </section>
</div><!-- Content / END -->

<!-- Footer / START -->
<footer class="footer">
    <div class="container">
      <span class="copyright">
        Copyright <?= \Config\Config::get("copyrightyear") ?>. All rights served.
      </span>
      <span class="links">
        <a href="#">Terms of service</a>
        <a href="#">Privacy policy</a>
      </span>
    </div>
</footer><!-- Footer / END -->

<?php
$page->addFooterJSifIE9("https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js", false);
$page->addFooterJSifIE9("https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js", false);
$page->addFooterJS("https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js", false);
$page->addFooterJS("main.js");
$page->addFooterJS("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js", false);
$page->renderFooter();
$page->echoFooter();