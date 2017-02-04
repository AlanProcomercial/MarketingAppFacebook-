@extends('layouts.baseFrontend')

@section('page')
Password reset
@endsection

@section('header')
    <header id="head" class="secondary">
        <div class="container">
                <h1>Password reset</h1>
        </div>
    </header>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-light mt-20" role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-two">Send Password Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection