@extends('layouts.admin')

@section('main')

<div class="row">
  <div class="col-sm-12">
    <h2>Bookings for {{ $cottage->name }}</h2>
    
    <p>{{ count($bookings) }} bookings</p>      
    
    <table class="table">
      <tr>
        <th>ID</th>
        <th>Booked on</th>
        <th>Arriving</th>
        <th>Leaving</th>
        <th>Nights</th>
        <th>Amount</th>
        <th>Paid</th>
        <th>&nbsp;</th>
      </tr>
      @foreach($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>{{ Carbon::parse($b->created_at)->format('d F') }}</td>
        <td>{{ $b->first_night->format('d F') }}</td>
        <td>{{ $b->depart->format('d F') }}</td>
        <td>{{ $b->nights }}</td>
        <td>&pound;{{ $b->amount }}</td>
        <td>&pound;{{ $b->paid }}</td>
        <td><a href="{{ URL::route('admin.booking', array($b->id)) }}" class="btn btn-primary">View</a></td>
      </tr>
      @endforeach
    </table>
  </div>
</div>

@stop