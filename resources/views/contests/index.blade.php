@extends('layouts.baseFrontend')

@section('page')
Contests
@endsection

@section('header')
 <header id="head" class="secondary">
    <div class="container">
            <h1>Contest</h1>
            <p>Apply for a contest or vote for a contestant</p>
    </div>
</header>
@endsection

@section('content')

<section class="news-box top-margin">	
        <div class="container">
            @foreach($contests as $contest)
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="newsBox">
                        <div class="thumbnail">
                            <figure><a href="{{ route('contest.show', $contest->id)}}"><img src="{{ $contest->image }}" alt=""></a></figure>
                            <div class="caption maxheight2">
                            <div class="box_inner">
                                        <div class="box">
                                            <p class="title"></p><h3>{!! $contest->name !!}</h3><p></p>
                                            <p>{!! $contest->description !!}</p>
                                            <hr>
                                            <small>Avalaible: {!! $contest->end !!}</small>
                                        </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>
        </div>
    </section>

@endsection
