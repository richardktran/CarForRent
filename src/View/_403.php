<link href="/assets/css/404-main.css" rel="stylesheet">
<div class="fix-wrp">
    <div class="animate-wrp">
        <div class="sky">
            <div class="car-wheels"></div>
            <div class="car">
                <div class="msg"><b><span>Oops!</span>May be I am on wrong way.</b></div>
            </div>
            <div class="car-wheels c1"></div>
            <div class="car1 c1"></div>
            <div class="cloud"></div>
            <div class="cloud2"></div>
            <div class="cloud1"></div>
            <div class="grass1"></div>
            <div class="grass"></div>
            <div class="grass2"></div>
            <div class="mountain"></div>
            <div class="mountain1"></div>
            <div class="tree"></div>
            <div class="tree-front"></div>
            <div class="road"></div>
            <div class="road-front"></div>
        </div>
    </div>
</div>
<!--/animate-wrp -->

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
    <!-- CONTAINER -->
    <div class="container">

        <!-- ERROR TITLE -->
        <div class="outer-wrapper">403<span>PERMISSION DENIED...</span></div>
        <!--/outer-wrapper -->

        <!-- SORRY -->
        <div class="message">
            <p>Unfortunately you do not have permission to access this page.</p><br>
            <p>Take a look around the rest of our site.</p>
        </div>

        <!-- NAVIGATION LINKS -->
        <div class="nav-wrapper">
            <a href="/">Home</a>
            <a href="#">Service</a>
            <a href="#">Contact us</a>
            <a href="#">Purchase</a>
        </div>
        <!--/nav-wrapper -->

        <!-- SOCIAL LINKS -->
        <div class="social-links">
            <a href="https://www.facebook.com/richardktran.dev/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </div>
        <!--/social-links -->
        <p class="copyrights">Copyright © 2016 NCode.Art All Right Reserved</p>
    </div>
    <!--/container -->
</div>
<!--/main-wrapper -->

<!-- COMMON SCRIPT -->
<script src="js/jquery-1.11.1.min.js"></script>
<script>
    function mainWindow() {
        $(".main-wrapper").css({
            width: $('html').width(),
            height: $('html').height() > $(window).height() ? $('html').height() : $(window).height()
        });
    }

    $(document).ready(function () {
        mainWindow();
    });
    $(window).resize(function (event) {
        mainWindow();
    });

    function animateWindow() {
        $(".animate-wrp").css({
            width: $(window).width(),
            height: $('.main-wrapper').height()
        });
    }

    $(document).ready(function () {
        animateWindow();
    });
    $(window).resize(function (event) {
        animateWindow();
    });
</script>
