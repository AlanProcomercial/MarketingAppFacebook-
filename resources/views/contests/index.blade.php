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
            @if(count($contests) == 0)
            <div class="row">
                <div class="col-lg-12">
                    <h1>Here contest yet!</h1>
                </div>
            </div>
            @endif
            @foreach($contests as $contest)
               <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="newsBox">
                            <div class="thumbnail">
                                <figure><a href="{{ route('contest.show', $contest->slug)}}"><img src="{{ $contest->image }}" alt=""></a></figure>
                                <div class="caption maxheight2">
                                <div class="box_inner">
                                            <div class="box">
                                                <p class="title"></p><h3>{!! $contest->name !!}</h3><p></p>
                                                <p>{!! $contest->description !!}</p>
                                                <hr>
                                                @if($contest->end <= date('Y-m-d'))
                                                    <small><strong>Finished at: </strong>{!! $contest->end !!}</small>
                                                @else
                                                    <small><strong>Avalaible to: </strong>{!! $contest->end !!}</small>
                                                @endif
                                                
                                            </div> 
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
