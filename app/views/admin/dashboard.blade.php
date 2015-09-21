@extends('layouts.admin')

@section('main')
<div class="row">
  <div class="col-sm-12">
    
    <h2>Bookings</h2>
    <p>Bookings made in the past 7 days.</p>
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
        <th>&nbsp;</th>
      </tr>
      @foreach($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->cottage->name }}</td>
        <td>{{ Carbon::parse($b->created_at)->format('d F') }}</td>
        <td>{{ Carbon::parse($b->first_night)->format('d F') }}</td>
        <?php $depart = Carbon::parse($b->last_night)->addDay(); ?>
        <td>{{ $depart->format('d F') }}</td>
        <td>{{ $b->nights }}</td>
        <td>£{{ $b->amount }}</td>
        <td>£{{ $b->paid }}</td>
        <td><a href="{{ URL::route('admin.booking', array($b->id)) }}" class="btn btn-primary">View</a></td>
      </tr>
      @endforeach
    </table>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    
    <h2>Cottages</h2>
    <p>All cottages.</p>
    <table class="table">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>&nbsp;</th>
      </tr>
    @foreach($cottages as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>
          <div class="btn-group">
            <a href="{{ URL::action('Admin\BookingController@cottage', array($c->id)) }}" class="btn btn-info">Bookings</a>
            <a href="{{ URL::action('Admin\CottageController@edit', array($c->id)) }}" class="btn btn-info">Edit</a>
          </div>
        </td>
      </tr>
      @endforeach 
    </table>
  </div>
</div>

@stop