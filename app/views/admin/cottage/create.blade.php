@extends('layouts.admin')

@section('js-head')
<link rel="stylesheet" href="{{ URL::asset('vendor/css/dropzone.css') }}" />
<script src="{{ URL::asset('vendor/js/dropzone.js') }}" ></script>
@stop

@section('main')
<div class="row">
  <div class="col-sm-12">
    <h1>Create Cottage</h1>    
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
    
    {{ HTML::ul($errors->all(), array('class'=>'alert alert-danger')) }}

    {{ Form::open(array('action' => array('Admin\CottageController@store'))) }}

    @include('admin.cottage.form')

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Save Cottage</button> or <a href="#" title="Don't save any changes and return">cancel</a>
    </div>

    {{ Form::close() }}

      
    
  </div>
</div>

@stop

@section('js-foot')
<script src="{{ URL::asset('vendor/js/bootstrap-datepicker.js') }}"></script>
<script>
var cottage_id = '';
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
  
    
});


// add a price row
function addPriceRow(type)
{
  var pricerow = $('.price-row');
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
  $('.price-row').last().after(html);
  html.slideDown(250);
}
</script>

@stop