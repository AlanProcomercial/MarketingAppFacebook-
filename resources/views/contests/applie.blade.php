@extends('layouts.baseFrontend')

@section('page')
    @foreach($contest as $contest)
         {!! $contest->name !!}
    @endforeach
@endsection

@section('header')
 <header id="head" class="secondary">
    <div class="container">
            <h1>Apply</h1>
            <p>{!! $contest->name !!}</p>
    </div>
</header>
@endsection

@section('content')
<div class="container">
    <div class="row">
            <nav id="filter" class="col-md-12 text-center">
                <ul>
                    <li><a href="{{ route('contest.show', $contest->slug) }}" class="current btn-theme btn-small"><i class="fa fa-arrow-left"></i> Back</a></li>
                </ul>
            </nav>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3 class="section-title">Hi <strong>{!! Auth::user()->name !!}</strong>, complete the form to apply in this contest</h3>

            @if(Session::has('message'))
                <div class="alert alert-danger">
                    <p>{!! Session::get('message') !!}</p>    
                </div>
            @endif

            <form class="form-light mt-20" role="form" method="POST" enctype="multipart/form-data" action="{{ route('apply.save', $contest->id) }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                    <label>Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/jpeg, image/png, image/jpg" required autofocus>
                        @if ($errors->has('photo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('photo') }}</strong>
                            </span>
                        @endif
                </div>
                <div id="image">
                        
                </div>
                <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                    <label>Descriptión</label>
                    <textarea class="form-control" name="description" required></textarea>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                        {!! captcha_img() !!}
                        <br><br>
                        <input type="text" class="form-control" name="captcha" required>
                         @if ($errors->has('captcha'))
                            <span class="help-block">
                                <strong>{{ $errors->first('captcha') }}</strong>
                            </span>
                        @endif
                </div>

                
                <div class="form-group">
                    <button type="submit" class="btn btn-two">Apply!</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
