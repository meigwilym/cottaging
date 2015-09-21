@extends('layouts.admin')

@section('js-head')
<link rel="stylesheet" href="{{ URL::asset('vendor/css/dropzone.css') }}" />
<script src="{{ URL::asset('vendor/js/dropzone.js') }}" ></script>
@stop

@section('main')
<div class="row">
  <div class="col-sm-12">
    <h1>Edit Cottage: {{{ $cottage->name }}}</h1>
    
    <ul class="nav nav-tabs edit-tabs">
      <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
      <li><a href="#images" data-toggle="tab">Images</a></li>
      <li><a href="#prices" data-toggle="tab">Prices</a></li>
    </ul>
    
  </div>
</div>


<div class="row">
  <div class="col-sm-12">
    
    <?php
    if(Session::has('priceerrors'))
    {
      echo '<div class="alert alert-danger">';
      $priceerrors = Session::get('priceerrors');
      echo '<p>Prices Error</p>';
      echo '<ul>';
      foreach($priceerrors as $e)
      {
        foreach($e->all() as $msg)
          echo '<li>'.$msg.'</li>';
      }    
      echo '</ul></div>';
    }
    ?>
    
    <div class="tab-content">
      <div class="tab-pane active" id="details">
        {{ HTML::ul($errors->all(), array('class'=>'alert alert-danger')) }}
    
        {{ Form::model($cottage, array('action' => array('Admin\CottageController@update', $cottage->id), 'method' => 'PUT')) }}

        @include('admin.cottage.form')

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Update Cottage</button> or <a href="#" title="Don't save any changes and return">cancel</a>
        </div>

        {{ Form::close() }}
        
      </div>
      
      <?php /* ============================================================================ */ ?>
      
      <div class="tab-pane" id="images">
        <h3>Images</h3>
        
        {{ Form::open(array('action' => array('Admin\Cottage\ImageController@store', $cottage->id), 'method' => 'POST', 'files' => true, 'id' => 'fileupload', 'class' => 'dropzone')) }}
        {{ Form::close() }}
        
        <div class="row">
        @foreach($cottage->images as $i)
          <div class="col-sm-3">
            <img src="{{ asset('media/thumb/'.$i->fullpath) }}" class="img-thumbnail">
            {{ Form::open(array('action' => array('Admin\Cottage\ImageController@destroy', $cottage->id), 'method' => 'DELETE', 'class' => 'deleteimg')) }}
            {{ Form::hidden('id', $i->id) }}
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
            {{ Form::close() }}
          </div>
        @endforeach
        </div>
      </div>
      
      <?php /* ============================================================================ */ ?>
      
      <div class="tab-pane" id="prices">
        <h3>Prices</h3>
        
        {{ Form::open(array('action' => array('Admin\Cottage\PriceController@update', $cottage->id), 'method' => 'post', 'class'=>'form-inline', 'role' => 'form')) }}
        
        <?php 
        $prices = $cottage->prices->toArray();
        $old_prices = Input::old('price');
        if(count($old_prices) > 0)
        {
          foreach(Input::old('price') as $price)
          {
            if(isset($price['id'])) continue;          
            $prices[] = $price;
          }
        }
        $i = 1; 
        ?>
        @if(!$prices)
        <div class="price-row">   
            {{ Form::hidden('price['.$i.'][cottage_id]', $cottage->id) }}
            @if(isset($p['id']))
              {{ Form::hidden('price['.$i.'][id]', $p['id']) }}
            @endif
            <div class="form-group">
              {{ Form::label('price['.$i.'][start]', 'From') }}
              {{ Form::text('price['.$i.'][start]', date('Y-m-d'), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'yyyy-mm-dd')) }}
            </div>
            <div class="form-group">
              {{ Form::label('price['.$i.'][end]', 'To') }}
              {{ Form::text('price['.$i.'][end]', date('Y-m-d'), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'yyyy-mm-dd')) }}
            </div>
            <div class="form-group">
              {{ Form::label('price['.$i.'][night_price]', 'Nightly Price (&pound;)') }}
              {{ Form::text('price['.$i.'][night_price]', 0, array('class' => 'form-control')) }}
            </div>
          </div>
        @endif
        @foreach($prices as $p)
          <div class="price-row">   
            {{ Form::hidden('price['.$i.'][cottage_id]', $cottage->id) }}
            @if(isset($p['id']))
              {{ Form::hidden('price['.$i.'][id]', $p['id']) }}
            @endif
            <div class="form-group">
              {{ Form::label('price['.$i.'][start]', 'From') }}
              {{ Form::text('price['.$i.'][start]', $p['start'], array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'yyyy-mm-dd')) }}
            </div>
            <div class="form-group">
              {{ Form::label('price['.$i.'][end]', 'To') }}
              {{ Form::text('price['.$i.'][end]', $p['end'], array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'yyyy-mm-dd')) }}
            </div>
            <div class="form-group">
              {{ Form::label('price['.$i.'][night_price]', 'Nightly Price (&pound;)') }}
              {{ Form::text('price['.$i.'][night_price]', $p['night_price'], array('class' => 'form-control')) }}
            </div>
          </div>
          <?php $i++; ?>
        @endforeach
        
        <div>
          <span class="btn-group">
            <button type="button" class="addrow-price-week btn btn-info"><i class="fa fa-plus"></i> Add Row Week</button>
            <button type="button" class="addrow-price-month btn btn-info"><i class="fa fa-plus"></i> Add Row Month</button>
          </span>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Save</button>          
          <button type="button" class="remove-price-row btn btn-danger"><i class="fa fa-trash-o"></i> Delete Row</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
    
  </div>
</div>

@stop

@section('js-foot')
<script src="{{ URL::asset('vendor/js/bootstrap-datepicker.js') }}"></script>
<script>
var cottage_id = <?php echo $cottage->id ?>;
$(function(){
  
  // delete image form
  $('form.deleteimg').submit(function(e){
    e.preventDefault();
    
    var form = $(this);
    
    $.post($(this).attr('action'), 
      $(this).serialize(), 
      function(data){
        if(data == 'deleted')
        {
          form.parent().remove();
        }
      },
      'json'
    );    
  });
  
  $('.addrow-price-week').on('click', function()
  {
    addPriceRow('week');
  });
  $('.addrow-price-month').on('click', function()
  {     
    addPriceRow('month');
  });
  
  $('.remove-price-row').on('click', function()
  {
    $('.price-row').last().slideUp (250, function(){
      $(this).remove();
    });
  });
    
});


// add a price row
function addPriceRow(type)
{
  var pricerow = $('.price-row');
  console.log(pricerow);
  var i = pricerow.length;
  var iname = 'price['+(i+1)+']'; //input name

  // start from the day after the end day of the last price 
  var start_date = $('input[name="price['+i+'][end]"]').val();
  var from = new Date(start_date), to = new Date(start_date);

  from.setDate(from.getDate() + 1);
  var fromMonth = from.getMonth() + 1;
  if(fromMonth < 10) fromMonth = '0'+fromMonth;
  var fromDate = from.getDate();
  if(fromDate < 10) fromDate = '0'+fromDate;
  var fromDateStr = from.getFullYear()+'-'+fromMonth +'-'+fromDate;

  var days = 7;
  if(type == 'month') days = 1;
  to.setDate(to.getDate() + days);
  if(type == 'month') to.setMonth(to.getMonth() + 1);
  var toMonth = to.getMonth() + 1; // add 1 as month is 0 indexed and 1 to add a month
  if(toMonth < 10) toMonth = '0' + toMonth;
  var toDate = to.getDate();
  if(toDate < 10) toDate = '0' + toDate;
  var toDateString = to.getFullYear()+'-'+toMonth+'-'+toDate;

  var html = '<div class="price-row">';
  html += '<input type="hidden" name="'+iname+'[cottage_id]" value="'+window.cottage_id+'" >';
  html += '<div class="form-group">';
  html += '<label for="'+iname+'[start]" class="form-label">From:</label>';
  html += '<input type="text" name="'+iname+'[start]" id="'+iname+'[start]" value="'+fromDateStr+'" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" >';
  html += '</div> <div class="form-group">';
  html += '<label for="'+iname+'[end]" class="form-label">To:</label>';
  html += '<input type="text" name="'+iname+'[end]" id="'+iname+'[end]" value="'+toDateString+'" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" >';
  html += '</div> <div class="form-group">';
  html += '<label for="'+iname+'[night_price]" class="form-label">Nightly Price (&pound;)</label>';
  html += '<input type="text" name="'+iname+'[night_price]" id="'+iname+'[night_price]" value="0" class="form-control" >';
  html += '</div></div>';

  html = $(html).hide();
  pricerow.last().after(html);
  html.slideDown(250);
}
</script>

@stop