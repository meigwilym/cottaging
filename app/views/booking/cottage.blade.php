
<div class="row">
  <div class="col-sm-12">
    <h2>{{ $bkng['name'] }}</h2>
    <p class="lead">From: {{ $bkng['first_night'] }} To: {{ $bkng['depart'] }} ({{ $bkng['nights'] }} Nights) Cost: {{ $bkng['cost'] }}</p>
    
    {{ HTML::ul($errors->all(), array('class'=>'alert alert-danger')) }}
    
  </div>  
</div>

<?php echo $form; ?>