@extends('layouts.admin')

@section('main')

<div class="row">
<div id="login" class="col-md-4 col-md-offset-4 login">
  
  <h2>Login</h2>
  {{ Form::open() }}

  @if ($errors->has('login'))
    <div class="alert alert-danger">{{ $errors->first('login', ':message') }}</div>
  @endif

  <div class="form-group">
    {{ Form::label('email', 'Email') }}
    {{ Form::text('email', null, array('class' => 'form-control')) }}
  </div>

  <div class="form-group">
    {{ Form::label('password', 'Password') }}
    {{ Form::password('password', array('class' => 'form-control')) }}
  </div>

  <div class="form-group">
    {{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
  </div>

  {{ Form::close() }}
</div>
</div>

@stop