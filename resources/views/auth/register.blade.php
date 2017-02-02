@extends('layouts.baseFrontend')

@section('page')
Register
@endsection

@section('header')
    <header id="head" class="secondary">
        <div class="container">
                <h1>Register</h1>
                <p>Create an account</p>
        </div>
    </header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3 class="section-title">Complete the form</h3>
            <form class="form-light mt-20" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Email</label>
                     <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                              @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                               @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>Password</label>
                      <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-two">Register!</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection