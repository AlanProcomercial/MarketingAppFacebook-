@extends('layouts.baseFrontend')

@section('page')
Log In
@endsection

@section('header')
    <header id="head" class="secondary">
        <div class="container">
                <h1>Log In</h1>
                <p>Log In with us or Facebook</p>
        </div>
    </header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3 class="section-title">
                Login or Facebook Login -  
                <a class="btn btn-link" href="{{ url('/register') }}">
                                        Register
                </a> 
            </h3>
            <form class="form-light mt-20" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-two">Login</button>
                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        Forgot Your Password?
                    </a>    
                     <a class="btn btn-two" href="redirect">Login <i class="fa fa-facebook-square"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection