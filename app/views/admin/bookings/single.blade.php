@extends('layouts.admin')

@section('main')

<div class="row">
  <div class="col-sm-12">
    <h1>Booking for {{ $booking->cottage->name }}</h1>
    
    <?php
    if($booking->first_night->lte(Carbon::now()) && $booking->depart->gte(Carbon::now())) : ?>
    <div class="alert alert-info">
      This is an active booking
    </div>
    <?php endif; ?>
    
    <table class="table">
      <tr>
        <td>Name</td>
        <td>{{ $booking->user->first_name.' '.$booking->user->last_name }}</td>
      </tr>
      <tr>
        <td>Arrive</td>
        <td>{{ $booking->first_night->format('d F') }}</td>
      </tr>
      <tr>
        <td>Depart</td>
        <td>{{ $booking->depart->format('d F') }}</td>
      </tr>
      <tr>
        <td>Nights</td>
        <td>{{ $booking->nights }}</td>
      </tr>
      <tr>
        <td>Cost/Paid</td>
        <td>&pound;{{ $booking->amount }} / &pound;{{ $booking->paid }}</td>
      </tr>
      <tr>
        <td>Address</td>
        <td>{{ $booking->user->address1.', ' }} 
          <?php echo ($booking->user->address2 == '') ? '' : $booking->user->address2.', '; ?>
          {{ $booking->user->town.', '.$booking->user->postcode }}</td>
      </tr>
      <tr>
        <td>Phone Number</td>
        <td>{{ $booking->user->telephone }}</td>
      </tr>
    </table>
    
    <p><a href="{{ URL::action('Admin\BookingController@cottage', array($booking->cottage->id)) }}">Back to the {{ $booking->cottage->name }} Bookings page</a>.</p>
      
  </div>
</div>

@stop 