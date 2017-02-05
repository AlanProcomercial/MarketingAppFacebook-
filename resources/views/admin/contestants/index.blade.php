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
	            Filter
	        </div>
	        <div class="panel-body">
	        	<form class="form-inline">
	        		<div class="form-group">
	        			<input type="text" class="form-control" v-model="filter.input" placeholder="Searh ....">
	        		</div>
	        		<div class="form-group">
	        			<input type="radio" v-model="filter.type" value="email" class="form-control">
	        			<label>Email</label>
	        		</div>
	        		<div class="form-group">
	        			<input type="radio" v-model="filter.type" value="name" class="form-control">
	        			<label>Name</label>
	        		</div>
	        		<div class="form-group">
	        			<button class="btn btn-primary" v-on:click.prevent="filterResult">Search <i class="fa fa-search"></i></button>
	        		</div>
	        		<div class="form-group">
	        			<button class="btn btn-danger" v-on:click.prevent="cleanFlter">Clean <i class="fa fa-clear"></i></button>
	        		</div>
	        	</form>
	        </div>
	     </div>
	 </div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            Data of the Contestants
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	        	<table class="table table-striped table-bordered">
	        		<thead>
	        			<tr>
	        				<th>Id</th>
		        			<th>Name</th>
		        			<th>Email</th>
		        			<th>Contest</th>
		        			<th>Descripction</th>
		        			<th>Total votes</th>
		        			<th>Banned?</th>
		        			<th>Actions</th>
	        			</tr>
	        		</thead>
        			<tbody>
        				<tr v-for="(contestant, index) in contestants" v-cloak>
        					<td>@{{ contestant.user.id }}</td>
        					<td>@{{ contestant.user.name }}</td>
        					<td>@{{ contestant.user.email }}</td>
        					<td>@{{ contestant.contest.name }}</td>
        					<td>@{{ contestant.contest.description }}</td>
        					<td v-if="!contestant.editing" class="text-center">@{{ contestant.total_votes }}</td>
        					<td v-else class="text-center">
        						<input  v-on:keydown.enter="update(contestant)" 
        								v-on:keyup.esc="contestant.editing = false" 
        								v-model="contestant.total_votes" 
        								type="text" class="form-control" ref="vote" size="3" >
        					</td>
        					<td v-if="contestant.banned" class="text-center"><i class="fa fa-ban"></i></td>
        					<td v-else></td>
        					<td class="text-center">
        					<!-- Boton para editar el voto-->
	                            <button 
	                            	v-if="!contestant.editing"
	                            	v-on:click="edit(contestant)" 
	                            	v-bind:disabled="contestant.banned == 1"
	                            	title="Edit" 
	                            	class="fa fa-pencil-square-o btn btn-primary btn-xs">
	                            </button>
	                           <!--/ Boton para editar el voto-->
	                           <!-- Boton para actualizar el voto-->
	                            <button 
	                            	v-else
	                            	v-on:click="update(contestant)" 
	                            	title="Save" 
	                            	class="fa fa-save btn btn-primary btn-xs">
	                            </button>
	                            <!-- /Boton para actualizar el voto-->
	                            <!-- Boton para descalificar usuario -->
	                            <button v-if="!contestant.banned" 
	                            	v-on:click="ban(contestant)"	
	                            	title="Ban user here" 
	                            	rel="tooltip" 
	                            	class="fa fa-ban fa-lg btn btn-warning btn-xs">
	                            </button>
	                            <!-- /Boton para descalificar usuario -->
	                            <!-- Boton para activar usuario -->
	                            <button v-else 
	                            	v-on:click="unBan(contestant)"	
	                            	title="Unban user here" 
	                            	rel="tooltip"  
	                            	class="fa fa-check fa-lg btn btn-success btn-xs">
	                            </button>
	                            <!-- /Boton para activar usuario -->
	                            <!-- Boton para eliminar usuario -->
	                            <button  v-on:click="deleteContestant(contestant, index)"
                            		title="Delete" 
                            		class="fa fa-trash-o fa-lg btn btn-danger btn-xs">
	                            </button>
	                            <!-- /Boton para eliminar usuario -->
	                        </a></td>
        				</tr>
        			</tbody>
	        	</table>
	        	<ul class="pager">
	        		<li class="previous" v-show="pagination.previous">
	        			<a style="cursor: pointer;" class="page-scroll" v-on:click="getContestantsPaginate('previous')">Previous</a>
	        		</li>
	        		<li class="next" v-show="pagination.next">
	        			<a style="cursor: pointer;"  class="page-scroll" v-on:click="getContestantsPaginate('next')">Next</a>
	        		</li>
	        	</ul>
	            <!-- /.table-responsive -->
	        </div>
	        <!-- /.panel-body -->
	    </div>
	    <!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
	</div>
@endsection

@section('js')
	<script type="text/javascript">
		Vue.http.headers.common['X-CSRF-TOKEN'] = "{!! csrf_token() !!}";
		new Vue({
			el: '#app',
			data: {
				contestants: [],
				pagination:{
					page: 1,
					previous: false,
					next: false 
				},
				filter: {
					input: '',
					type: 'email',

				}
			},
			mounted: function(){
				this.getContestantsPaginate();
			},
			methods:{
				getContestantsPaginate: function(direction){

					if (direction === 'previous'){
						--this.pagination.page;
					}
					else if (direction === 'next'){
						++this.pagination.page;
					}

					this.$http.get('/contestants?page='+this.pagination.page).then(function(response){
						this.contestants = [];
						for (var i = 0 ; i < response.body.data.length; i++) {
								var data = response.body.data;
								this.contestants.push(data[i]);
							};
						this.pagination.next = response.body.next_page_url;
						this.pagination.previous = response.body.prev_page_url;						
					});
				},
				edit: function(contestant){
					Vue.set(contestant, 'editing', true);
				},
				update: function(contestant){
					this.$http.put('/contestants/'+contestant.id, {vote: contestant.total_votes}).then(function(response){
						Vue.set(contestant, 'editing', false);
					});
					
				},
				deleteContestant: function(contestant, index){
					var r = confirm("Do you want delele to "+ contestant.user.name +" in the constest " + contestant.contest.name +"?");
						if(r == true){
							this.$http.delete('/contestants/'+contestant.id, {vote: contestant.total_votes})
								.then(function(response){
									this.contestants.splice(index, 1);
								 });			
						}
					
				},
				ban: function(contestant){
					this.$http.put('/contestants/ban/'+contestant.id, {ban: true}).then(function(response){
						contestant.banned = true;
					});
				},
				unBan: function(contestant){
					this.$http.put('/contestants/ban/'+contestant.id, {ban: false}).then(function(response){
						contestant.banned = false;
					});
				},
				filterResult: function(){

					this.$http.post('/contestants/results', {type: this.filter.type, search: this.filter.input}).then(function(response){
						this.contestants = [];
						for (var i = 0 ; i < response.body.data.length; i++) {
								var data = response.body.data;
								this.contestants.push(data[i]);
							};
					});
				},
				cleanFlter: function(){

					this.filter.input = '';
					this.getContestantsPaginate();
				}
			} 
		});
	</script>
@endsection
