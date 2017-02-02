@extends('layouts.baseFrontend')

@section('page')
Contests
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('header')
 <header id="head" class="secondary">
    <div class="container">
            <h1>{!! $contest->name !!}</h1>
            <p>{!! $contest->description !!}</p>
    </div>
</header>
@endsection

@section('content')
<section class="container">
		@if($contest->end <= date('Y-m-d'))
        	<di class="row">
        		<div class="col-lg-4 col-lg-offset-4">
        			<div class="alert alert-danger">
        			<p><strong>This contest finished at {!! $contest->end !!}</strong></p>
        		</div>
        		</div>
        	</di>
         @endif
		<div class="row">
			<nav id="filter" class="col-md-12 text-center">
				<ul>
					<li><a href="{{ url('contests') }}" class="current btn-theme btn-small"><i class="fa fa-arrow-left"></i> Back</a></li>
				<!-- Mostrar el boto de concursar si la fecha eta entre en inicio o el fin del concurso-->
				@if(date('Y-m-d') >= $contest->start OR date('Y-m-d') < $contest->end)
					<li><a href="{{ route('contest.applie', $contest->id )}}" class="current btn-theme btn-small">Apply for this contest</a></li>
				@endif
					<li><a href="javascript:;" v-on:click="invite({{$contest->id}})" class="current btn-theme btn-small">Invite others friends! <i class="fa fa-facebook-square"></i></a></li>
				</ul>
			</nav>
		</div>
		<div class="row" v-if="message.show">
        		<div class="col-lg-4 col-lg-offset-4">
        			<div v-bind:class="[message.type]">
        			<p><strong>@{{ message.text }}</p>
        			</div>
        		</div>
            </div>
		<div class="row flat" v-cloak>
			<div class="col-lg-3 col-md-3 col-xs-6" v-for="contestant in contestants">
				<ul class="plan plan2">
					<li class="plan-name">@{{ contestant.user.name }}</li>
					<figure><img v-bind:src="contestant.photo" alt=""></figure>
					<li><strong>@{{ contestant.description }}</strong></li>
					<li><strong>Votes: @{{ contestant.total_votes }} <i class="fa fa-arrow-up"></i></strong></li>
					<li class="plan-action">
						<a  v-if="vote" v-on:click="vote(contestant)" class="btn">
							<span v-if="contestant.voting">Voting...</span>
							<span v-else>Vote</span>
						</a> <!-- Boton que se muestra si eñ visitante habilitado para votar en este concurso -->
						<button v-else class="btn" disabled="">Vote</button> <!-- Boton que se muestra cuando el visitante ya voto en este concurso -->
					</li>
				</ul>
			</div>
		</div>
	</section>
@endsection

@section('js')
	<script type="text/javascript">
		var id = {!! $contest->id !!};
		new Vue({
			el: '#app',
			data: {
				contestants: [],
				vote: true,	//Cuando se verifique la ip, esta propiedad cambiará a FALSE, inhabilitando los botones  de votar
				message: {show: false, text: '', tipe: ''}  //propieda para agregar un mensaje dinamico
				},
			mounted: function(){
				this.getContestants();
				this.verifyIp();
			},
			methods:{
				getContestants: function(){ //Funcion que carga los participantes
					this.$http.get('/api/contestants/'+id).then(function(response){
							
							for (var i = 0 ; i < response.body.length; i++) {
								this.contestants.push(response.body[i]);
							};

							if(this.contestants.length == 0){
								this.message.text = "No contestants yet!";
								this.message.type = "alert alert-danger";
								this.message.show = true;
							}
					});	
				},
				verifyIp: function(){ //funcion para verificar si la ip del visitante ya realizo la votacion en este concurso
					this.$http.get('/api/verifyIp/'+id).then(function(response){
							var data = response.body;
							if(data.canVote == false){
								this.vote = false; //Si el visitante ya voto, de seabilitan los botones de votar
								/*Mostramos un mensaje de que ya votó*/
								this.message.text = "You already votes for this contest from this computer!";
								this.message.type = "alert alert-warning";
								this.message.show = true;
							}
					});			
				},
				vote: function(contestant){
					this.$http.post('/api/votes/save', {id: id, contestant_id: contestant.id}).then(function(response){
							var data = response.body;
							if(data.vote == true){
								contestant.total_votes ++;
								this.message.text = "Congratulations, yo voted in this contest for" + contestant.user.name;
								this.message.type = "alert alert-success";
								this.message.show = true;
								this.verifyIp();
							}else{
								this.message.text = "Error";
								this.message.type = "alert alert-danger";
								this.message.show = true;
								this.verifyIp();
							}
					});			
				},
				invite: function(id){
					var contest = "http://localhost:8000/contests/"+id;
					//En este caso use la variable url como muestra porque el cuadro de dialogo de facebook da error con la url local
					var url = "https://github.com/AlanProcomercial/MarketingAppFacebook-";

					FB.ui(
					 {
					  	 method: 'share',
					 	 href: url
						}, function(response){});
					}
			} 
		});
	</script>
@endsection
