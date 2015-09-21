@extends('layouts.admin')

@section('main')

<div class="row">
  <div class="col-sm-12">
    <h1>{{ $title }} Bookings</h1>
  </div>
  
</div>

<div class="row">
  <div class="col-sm-12">
    <table class="table">
      <tr>
        <th>ID</th>
        <th>Cottage</th>
        <th>Booked on</th>
        <th>Arriving</th>
        <th>Leaving</th>
        <th>Nights</th>
        <th>Amount</th>
        <th>Paid</th>
        <th>&nbsp</th>
      </tr>
      @foreach($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->cottage->name }}</td>
        <td>{{ $b->created_at->format('d F') }}</td>
        <td>{{ $b->first_night->format('d F') }}</td>
        <td>{{ $b->depart->format('d F') }}</td>
        <td>{{ $b->nights }}</td>
        <td>£{{ $b->amount }}</td>
        <td>£{{ $b->paid }}</td>
        <td><a href="{{ URL::route('admin.booking', array($b->id)) }}" class="btn btn-primary">View</a></td>
      </tr>
      @endforeach
    </table>
  </div>  
</div>

@stop