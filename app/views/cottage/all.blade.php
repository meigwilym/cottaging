@extends('layouts.default')

@section('main')
<div class="row">
  <div class="col-sm-12">
    <h2>All Cottages</h2>
  </div>
</div>

@foreach ($cottages->cottages as $c)      
<div class="cottage row">
  
  <div class="col-sm-12">
    <h2><?php echo link_to_route('single', $c->name, array('slug' => $c->slug), array('title'=>'View details')); ?></h2>
  </div>
  
  <div class="col-sm-4 thumbnail">
    <?php 
      $img_ar = $c->images->toArray();
      if(count($img_ar) > 0):
        $img = array_shift($img_ar); 
    ?>
        <a href="{{ route('single', array('slug' => $c->slug)) }}">
          <img src="{{ URL::asset('media/'.$img['fullpath']) }}" class="img-responsive">
        </a>
    <?php endif; ?>
    <img src="" />
  </div>  
  
  <div class="col-sm-8">
    <p class="lead">{{{ $c->summary }}}</p>
    {{{ $c->description }}}
    <p class="text-center"><a href="{{ route('single', array('slug' => $c->slug)) }}#availability" class="btn btn-primary btn-lg" title="Check availability and book">Book Now!</a> or <?php echo link_to_route('single', 'View the Details', array('slug' => $c->slug), array('title'=>'Further pictures and details of '.$c->name.' Holiday Cottage')); ?></p>
  </div>
  
</div>
@endforeach

@stop