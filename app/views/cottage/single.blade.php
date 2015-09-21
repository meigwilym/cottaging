@extends('layouts.default')

@section('title')
{{{ $cottage->page_title }}}
@stop

@section('meta')
<meta name="description" content="{{{ $cottage->summary }}}" /> {{--  70 chars --}}
<meta name="keywords" content="{{{ $cottage->keywords }}}" />   {{-- 155 chars --}}

<meta property="og:title" content="{{{ $cottage->page_title }}}" />
<meta property="og:type" content="article" />
<meta property="og:image" content="@{{ URL::asset('media/thumb/'.$img->fullpath) }}" />
<meta property="og:url" content="" />
<meta property="og:description" content="{{{ $cottage->summary }}}" />
@stop

@section('js-head')
<link rel="stylesheet" src="{{ URL::asset('vendor/galleria/themes/azur/galleria.azur.css') }}" media="screen" />
<script src="{{ URL::asset('vendor/galleria/galleria-1.3.3.min.js') }}"></script>
<script>
WC.cottage = {{ $cottage->toJson() }};
WC.bookings = {{ $bookings->toJson() }};
</script>
@stop

@section('main')

<section class="cottage-preview">

  <div class="row">
    <div class="col-md-8">
      <div class="galleria">
        @foreach($cottage->images as $img)
          <a href="{{ URL::asset('media/'.$img->fullpath) }}"><img src="{{ URL::asset('media/thumb/'.$img->fullpath) }}" data-big="{{ URL::asset('media/original/'.$img->fullpath) }}" data-title="{{{ $cottage->name }}}" data-description="{{ area_leaf($cottage->areas->toArray()) }}"></a>
        @endforeach
      </div>
    </div>
    <div class="col-md-4">
      <div class="page-header">
        <h1>{{{ $cottage->name }}} <small>{{ area_leaf($cottage->areas->toArray()) }}</small></h1>
      </div>
      @if (Sentry::check())
        @if(Sentry::getUser()->hasAccess('admin'))
        <p>{{ link_to_action('Admin\CottageController@edit', 'Edit Cottage', array('id' => $cottage->id)) }}</p>
        @endif
      @endif
      <div class="breadcrumbs">
        {{ area_breadcrumb($cottage->areas->toArray()) }}
      </div>
      <p class="lead">{{{ $cottage->summary }}}</p>
      <p>
        Sleeps: <strong>{{{ $cottage->sleeps }}}</strong><br />
        Bedrooms: <strong>{{{ $cottage->bedrooms }}}</strong><br />
        Bathrooms: <strong>{{{ $cottage->bathrooms }}}</strong> <br />
        @if($cottage->dogs > 0)
          Dogs: <strong>{{{ $cottage->dogs }}} </strong>
        @endif
      </p>
      <h4>Features</h4>
      
      <ul class="fa-ul">
        @foreach($cottage->features->lists('name') as $li)
        <li><i class="fa fa-check-square"></i> {{{ $li }}}</li>
        @endforeach
      </ul>
      
      <p>Prices from <span>£{{{ $prices['min'] }}}</span> to <span>£{{{ $prices['max'] }}}</span> per night.</p>
    </div>
  </div>
</section>

<section>

  <div class="row"> <!-- description/accommodation -->
    <div class="col-md-6">
      <h3>{{{ $cottage->name }}}</h3>
      {{{ $cottage->description }}}
    </div>
    <div class="col-md-6">
      <h3>The Accommodation</h3>
      {{{ $cottage->accommodation }}}
    </div>  
  </div>
</section>

<section>                                                   <!-- availability -->
  <div id="availability" class="row">
    <div  class="col-sm-12">
      <hr>
      <h3>Check Availability</h3>
      <p>Arrival days are <span style="background:#adffad;padding:0px 2px;">green</span>.</p>
    </div>
    <div class="col-md-12">
      <div class="calendar_wrap">
        <div class="calendar_inner ">
          <?php
          $now = Carbon::now()->firstOfMonth();
          $months = array();
          // show a calendar for the next 12 months
          for($i = 0; $i < 12; $i++)
          {
            $cal = new \Cottaging\Presenters\Calendar(array('start_day' => 1, 'start_days' => $cottage->start_days));

            echo '<div class="calendar_month ">';

            if($i != 0)
              $now->firstOfMonth()->addMonth(1);
            echo $cal->render($now, $bookings);

            echo '</div>';

            $months[] = $now->format('F');
          }
          ?>
        </div>
        <div class="calendar_nav text-center">
          <a href="#" class="move_month_left" title="Back one month"><span class="glyphicon glyphicon-chevron-left"></span></a>&nbsp;
          <?php
          $i = 0;
          foreach($months as $m)
          {
            echo '<a href="#" data-month="' . $i . '" class="move_month" title="Jump to ' . $m . '">' . $m . '</a> &nbsp;';
            $i++;
          }
          ?>
          <a href="#" class="move_month_right" title="Forward one month"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">    
    <h2 class="col-sm-12 ">Dates <button type="submit" class="reset-dates btn btn-default btn-sm" title="Choose another set of dates">Reset the Dates</button></h2>
    <div class="col-sm-2 form-group">
      {{ Form::label('arriving', 'Arriving', array('class'=>'control-label')) }}
      {{ Form::text('arriving', '', array('class'=> 'form-control')) }}
    </div>
    <div class="col-sm-2 form-group">
      {{ Form::label('departing', 'Departing', array('class'=>'control-label')) }}
      {{ Form::text('departing', '', array('class'=> 'form-control')) }}
    </div>
    <div class="col-sm-2 form-group">
      {{ Form::label('nights', 'Nights', array('class'=>'control-label')) }}
      {{ Form::text('nights', '', array('class'=> 'form-control')) }}
    </div>
    <div class="col-sm-2 form-group">
      {{ Form::label('cost', 'Cost', array('class'=>'control-label')) }}
      <div class="input-group">
        <span id="costspinner" class="input-group-addon">£</span>
        {{ Form::text('cost', '', array('class'=> 'form-control', 'placeholder'=>'0')) }}
      </div>
    </div>
  </div>

  <?php // booking form from view->nest ?>
  <?php echo $form; ?>
  
</section>
<section>
  <div class="row">
    <div class="col-sm-12" id="cotmap" style="height:250px"></div>
  </div>
</section>

@stop

@section('js-foot')
<script src="{{ URL::asset('vendor/galleria/themes/azur/galleria.azur.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
Galleria.configure({
  imageCrop: 'landscape'
});
Galleria.run('.galleria');
function map_initialize() {
  var cottage = new google.maps.LatLng(WC.cottage.lat, WC.cottage.lon);
  var mapOptions = {
    zoom: 10,
    center: cottage
  };

  var map = new google.maps.Map(document.getElementById('cotmap'), mapOptions);
  
  var marker = new google.maps.Marker({
        position: new google.maps.LatLng(WC.cottage.lat, WC.cottage.lon),
        map: map,
        title: WC.cottage.name
    });
  var contentString = '<div id="content"><h3>'+WC.cottage.name+'</h3></div>';
  var infowindow = new google.maps.InfoWindow({
            content: contentString
  });


google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });
}

google.maps.event.addDomListener(window, 'load', map_initialize);
</script>
<script src="{{ URL::asset('vendor/galleria/themes/azur/galleria.azur.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendor/js/jquery.easing.1.3.js') }}"></script>
<script type="text/javascript" src="{{URL::asset('js/app.js')}}"></script>
@stop