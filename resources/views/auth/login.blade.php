@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center my-5">
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
      @if ($errors->has('email'))
      <span class="error text-danger">
        {{ $errors->first('email') }}
      </span>
      @endif
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
      @if ($errors->has('password'))
      <span class="error text-danger">
          {{ $errors->first('password') }}
      </span>
      @endif
    </div>
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    
    <button type="submit" class="btn btn-primary">Login</button>

    <a href="{{route('register')}}">
    <button type="button" class="btn btn-primary">Register</button>
    <a>
  </form>
</div>
@endsection
