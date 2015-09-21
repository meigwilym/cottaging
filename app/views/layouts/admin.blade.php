<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>@section('title')
  Cottaging - property booking application
@show</title>

@yield('meta')

<link rel="stylesheet" href="{{URL::asset('vendor/css/bootstrap.min.css')}}" media="screen" />
<link rel="stylesheet" href="{{URL::asset('vendor/css/font-awesome.min.css')}}" media="screen" />
<link rel="stylesheet" href="{{URL::asset('vendor/css/datepicker3.css')}}" media="screen" />
<link rel="stylesheet" href="{{URL::asset('css/style.css')}}" media="screen" />
<link rel="stylesheet" href="{{URL::asset('css/admin.css')}}" media="screen" />

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
        <h1>Cottaging</h1>
        <p>Property Booking Administration</p>
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
      <nav class="wc-navbar-collapse" role="navigation">
        <ul class="nav navbar-nav">
          <li><a href="{{ URL::to('admin') }}">Dashboard</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cottages <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('admin.cottage') }}">View All</a></li>
              <li><a href="{{ route('admin.cottage.create') }}">Create New</a></li>
            </ul>
            
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bookings <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="{{ URL::action('Admin\BookingController@index') }}">Future</a></li>
              <li><a href="{{ URL::route('admin.bookings.period', array('active') ) }}">Active</a></li>
              <li><a href="{{ URL::route('admin.bookings.period', array('past')) }}">Past</a></li>
            </ul>
          </li>
        </ul>

      </nav>
    </div>
  </div>
</header>
    
<div class="container page-inner">
  @yield('main')
</div>

<footer id="footer">
  <div class="container"></div>
</footer>


  @yield('js-foot')

</body>
</html>