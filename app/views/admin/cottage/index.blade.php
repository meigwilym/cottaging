@extends('layouts.admin')

@section('main')

<div class="row">
  <div class="cols-sm-12">
    <h2>Cottages</h2>
    
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