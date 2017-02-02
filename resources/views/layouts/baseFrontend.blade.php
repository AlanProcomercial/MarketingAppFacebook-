<!--
Author: WebThemez
Author URL: http://webthemez.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="free-educational-responsive-web-template-webEdu">
  @yield('meta')
	<meta name="author" content="webThemez.com">
	<title>Phototec | @yield('page') </title>
	<link rel="favicon" href="{{ asset('frontend/images/favicon.png') }}') }}">
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}"> 
	<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-theme.css') }}" media="screen"> 
	<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel='stylesheet' id='camera-css'  href="{{ asset('frontend/css/camera.css') }}" type='text/css' media='all'> 
	<!-- HTML5 shim and Respond.js') }} IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="{{ asset('frontend/js/html5shiv.js') }}') }}"></script>
	<script src="{{ asset('frontend/js/respond.min.js') }}') }}"></script>
	<![endif]-->

	<!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
      <script src="{{ asset('vue/vue.js') }}"></script>
    <script src="{{ asset('vue/vue-resource.min.js') }}"></script>
</head>
<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<a class="navbar-brand" href="index.html">
					<img src="{{ asset('frontend/images/logo.png') }}" alt="Techro HTML5 template"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right mainNav">
					<li {{ Request::is('/') ? 'class=active' : ''}}><a href="{{ url('/') }}">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Courses</a></li>
					<li><a href="#">Price</a></li>
					<li {{ Request::is('contests*') ? 'class=active': '' }}><a href="{{ url('/contests') }}">Contests</a></li>
					<li><a href="#">Contact</a></li>
					@if(Auth::check())
						<li><a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{!! Auth::user()->name !!} <i class="fa fa-sign-out fa-fwt" rel="tooltip" title="logout"></i></a></li>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                  	{{ csrf_field() }}
                         </form>
					@else
					    <li {{ Request::is('login') ? 'class=active' : ''}}><a href="{{ route('login') }}">Login <i class="fa fa-user"></i></a></li>
					@endif

				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
	<!-- /.navbar -->
	<div id="app">
		<div class="header">
			@yield('header')
		</div>

		<div class="content">
			@yield('content')	
		</div>
	</div>
	
      
    	 
    <footer id="footer">
 
		<div class="container">
   <div class="row">
  <div class="footerbottom">
    <div class="col-md-3 col-sm-6">
      <div class="footerwidget">
        <h4>
          Course Categories
        </h4>
        <div class="menu-course">
          <ul class="menu">
            <li><a href="#">
                List of Technology 
              </a>
            </li>
            <li><a href="#">
                List of Business
              </a>
            </li>
            <li><a href="#">
                List of Photography
              </a>
            </li>
            <li><a href="#">
               List of Language
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="footerwidget">
        <h4>
          Products Categories
        </h4>
        <div class="menu-course">
          <ul class="menu">
            <li> <a href="#">
                Individual Plans  </a>
            </li>
            <li><a href="#">
                Business Plans
              </a>
            </li>
            <li><a href="#">
                Free Trial
              </a>
            </li>
            <li><a href="#">
                Academic
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="footerwidget">
        <h4>
          Browse by Categories
        </h4>
        <div class="menu-course">
          <ul class="menu">
            <li><a href="#">
                All Courses
              </a>
            </li>
            <li> <a href="#">
                All Instructors
              </a>
            </li>
            <li><a href="#">
                All Members
              </a>
            </li>
            <li>
              <a href="#">
                All Groups
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6"> 
            	<div class="footerwidget"> 
                         <h4>Contact</h4> 
                        <p>Lorem reksi this dummy text unde omnis iste natus error sit volupum</p>
            <div class="contact-info"> 
            <i class="fa fa-map-marker"></i> Kerniles 416  - United Kingdom<br>
            <i class="fa fa-phone"></i>+00 123 156 711 <br>
             <i class="fa fa-envelope-o"></i> youremail@email.com
              </div> 
                </div><!-- end widget --> 
    </div>
  </div>
</div>
			<div class="social text-center">
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-dribbble"></i></a>
				<a href="#"><i class="fa fa-flickr"></i></a>
				<a href="#"><i class="fa fa-github"></i></a>
			</div>

			<div class="clear"></div>
			<!--CLEAR FLOATS-->
		</div>
		<div class="footer2">
			<div class="container">
				<div class="row">

					<div class="col-md-6 panel">
						<div class="panel-body">
							<p class="simplenav">
								<a href="index.html">Home</a> | 
								<a href="about.html">About</a> |
								<a href="courses.html">Courses</a> |
								<a href="price.html">Price</a> |
								<a href="videos.html">Videos</a> |
								<a href="contact.html">Contact</a>
							</p>
						</div>
					</div>

					<div class="col-md-6 panel">
						<div class="panel-body">
							<p class="text-right">
								Copyright &copy; 2014. Template by <a href="http://webthemez.com/" rel="develop">WebThemez.com</a>
							</p>
						</div>
					</div>

				</div>
				<!-- /row of panels -->
			</div>
		</div>
	</footer>

	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="{{ asset('frontend/js/modernizr-latest.js') }}"></script> 
	<script type='text/javascript' src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('frontend/js/fancybox/jquery.fancybox.pack.js') }}"></script>
    
    <script type='text/javascript' src="{ asset('frontend/js/jquery.mobile.customized.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('frontend/js/jquery.easing.1.3.js') }}"></script> 
    <script type='text/javascript' src="{{ asset('frontend/js/camera.min.js') }}"></script> 
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script>
		jQuery(function(){
			
			jQuery('#camera_wrap_4').camera({
                transPeriod: 500,
                time: 3000,
				height: '600',
				loader: 'false',
				pagination: true,
				thumbnails: false,
				hover: false,
                playPause: false,
                navigation: false,
				opacityOnGrid: false,
				imagePath: '/frontend/images/'
			});

		});
      
	</script>
	  <script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '1422490531150653',
	      xfbml      : true,
	      version    : 'v2.8'
	    });
	    FB.AppEvents.logPageView();
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>

  @yield('js')
    
</body>
</html>
