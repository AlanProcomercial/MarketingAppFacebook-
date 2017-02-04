@extends('layouts.baseBackend')

@section('page')
	Dashboard
@endsection

@section('header')
	Dashboard
@endsection

@section('content')
<div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-facebook fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Total accounts:</div>
                                <div class="huge">{!! $totalAccounts !!}</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-table fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Total Contests:</div>
                                <div class="huge">{!! $totalConstests !!}</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/contests') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-group fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Total Contestatns:</div>
                                <div class="huge">{!! $totalConstestants !!}</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/contestants') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
@endsection