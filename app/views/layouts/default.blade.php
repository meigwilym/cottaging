<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>@section('title')
  Cottaging - Property Booking Application
@show</title>

@yield('meta')

<link rel="stylesheet" href="{{URL::asset('vendor/css/bootstrap.min.css')}}" media="screen" />
<link rel="stylesheet" href="{{URL::asset('vendor/css/font-awesome.min.css')}}" media="screen" />
<link rel="stylesheet" href="{{URL::asset('css/style.css')}}" media="screen" />

<!--[if lte IE 9]><link rel="stylesheet" href="{{URL::asset('css/ie.css')}}" media="screen" />
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<script type="text/javascript" src="{{URL::asset('vendor/js/jquery-1.10.2.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('vendor/js/bootstrap.min.js')}}"></script>

<script>var baseurl = "{{ url('/') }}/";var WC = {}</script>

<?php if(isset($j_s)): ?>
<script>var pagevars = <?php echo json_encode($j_s); ?>;</script>
<?php endif; ?>

@yield('js-head')

</head>
<body>
<header class="navbar" role="banner">
  
  <div class="container">
    <div class="logo row">
      <div class="col-sm-12">
        <h1>{{ Config::get('cottaging.site-name') }}</h1>
        <p>Property Booking Application</p>
      </div>
    </div>
  </div>  
  
  <div class=" menu-wrapper">
    <div class="container  main-menu">
       <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".wc-navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <nav class="nav-collapse wc-navbar-collapse" role="navigation">
        <ul class="nav navbar-nav">
          <li><a href="/">Home</a></li>
          <li><a href="{{ route('all') }}">Our Cottages</a></li>
        </ul>

      </nav>
    </div>
  </div>
</header>
    
<div class="container page-inner">
  @yield('main')
</div>

<footer id="footer">
<div class="container">
  <div id="footer" class="row">
    <div class="col-md-4">
      <h3 class="widget-title">Address</h3>
      <div class="widget-inner">
        <address>
          <ul class="fa-ul">
             <li><i class="fa-li fa fa-map-marker"></i>Address</li>
            <li><i class="fa-li fa fa-phone"></i>+44 (0) 000 000 </li>
            <li><i class="fa-li fa fa-print"></i>+44 (0) 000 000</li>
            <li><i class="fa-li fa fa-envelope"></i>{{ Config::get('cottaging.contact-email') }}</li>
          </ul>
        </address>
      </div>
    </div>
    
    <div class="col-md-4">
      <h3 class="widget-title">About Us</h3>
      <ul>
        <li><a href="#">1st Menu Item</a></li>
      </ul>
    </div>
    
    <div class="col-md-4">
      <h3 class="widget-title">User</h3>
      <ul>
      @if (Sentry::check())
        @if(Sentry::getUser()->hasAccess('admin'))
        <li {{ (Request::is('admin*') ? 'class="active"' : '') }}><a href="{{ URL::to('admin') }}">Admin</a></li>
        <li><a href="{{ URL::to('logout') }}">Logout</a></li>
        @endif
      @else
        <li><a href="{{ URL::to('login') }}">Log in</a></li>
      @endif
      </ul>
    </div>
  </div>
</div><!-- /footer -->
</footer>
  <section id="footer-menu">
    <div class="container">
      <div class="foot-wrapper">
        <div class="row">
          <div class="col-sm-4">
            <p class="copyright"><a href="http://github.com/meigwilym/cottaging" title="Cottaging on Github">Cottaging - a property booking application</a>. </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  @yield('js-foot')

</body>
</html>