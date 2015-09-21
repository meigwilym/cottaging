@extends('layouts.admin')

@section('main')

<section class="cottage-preview">

  <div class="row">
    <div class="col-md-8">
        @foreach($cottage->images as $img)
        <img src="{{ URL::asset('media/thumb/'.$img->fullpath) }}" data-title="{{{ $cottage->name }}}" data-description="{{ area_leaf($cottage->areas->toArray()) }}" class="img-thumbnail">
        @endforeach
    </div>
    <div class="col-md-4">
      <div class="page-header">
        <h1>{{{ $cottage->name }}} <small>{{ area_leaf($cottage->areas->toArray()) }}</small></h1>
      </div>
      
      <p>{{ link_to_action('Admin\CottageController@edit', 'Edit Cottage', array('id' => $cottage->id)) }}</p>
      
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


@stop