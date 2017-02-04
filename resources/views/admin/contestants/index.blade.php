@extends('layouts.baseBackend')

@section('page')
Contestants
@endsection

@section('header')
Contestants
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            Data of the Participants
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-6"><div class="dataTables_length" id="dataTables-example_length"><label>Show <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-6"><div id="dataTables-example_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="dataTables-example"></label></div></div></div><div class="row"><div class="col-sm-12"><table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
	                <thead>
	                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 96px;">Name</th><th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 130px;">Email</th><th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Contest: activate to sort column ascending" style="width: 197px;">Contest</th><th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Total Votes: activate to sort column ascending" style="width: 121px;">Total Votes</th><th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="width: 153px;">Description</th><th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending" style="width: 90px;">Actions</th></tr>
	                </thead>
	                <tbody>
	                    
	                    
	                <tr class="gradeX odd" role="row">
	                        <td class="sorting_1">Luis Vasquez</td>
	                        <td>luis@hotmail.com</td>
	                        <td>Semi professional camera</td>
	                        <td class="text-center">0</td>
	                        <td>Prueba de Ofimatica</td>
	                        <td class="text-center">
	                            <a href="edit-participants.html" title="Edit" class="fa fa-pencil-square-o btn btn-primary btn-xs"></a>
	                            <a href="#" title="Delete" class="fa fa-trash-o fa-lg btn btn-danger btn-xs"><!--<a-->
	                        </a></td>
	                    </tr></tbody>
	            </table></div></div><div class="row"><div class="col-sm-6"><div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div></div><div class="col-sm-6"><div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate"><ul class="pagination"><li class="paginate_button previous disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous"><a href="#">Previous</a></li><li class="paginate_button active" aria-controls="dataTables-example" tabindex="0"><a href="#">1</a></li><li class="paginate_button next disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next"><a href="#">Next</a></li></ul></div></div></div></div>
	            <!-- /.table-responsive -->
	        </div>
	        <!-- /.panel-body -->
	    </div>
	    <!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
	</div>
@endsection