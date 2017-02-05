@extends('layouts.baseFrontend')

@section('page')
Contests
@endsection

@section('header')
 <header id="head" class="secondary">
 	@foreach($contest as $contest)
	    <div class="container">
	            <h1>{!! $contest->name !!}</h1>
	            <p>{!! $contest->description !!}</p>
	    </div>
    @endforeach
</header>
@endsection

@section('content')
<section class="container">
		<div class="row">
			<nav id="filter" class="col-md-12 text-center">
				<ul>
					<li><a href="{{ url('contests') }}" class="current btn-theme btn-small"><i class="fa fa-arrow-left"></i> Back</a></li>
				<!-- Mostrar el boton de concursar si la fecha eta entre en inicio o el fin del concurso-->
				@if($contest->start <=  date('Y-m-d') AND  $contest->end >= date('Y-m-d'))
					<li><a href="{{ route('contest.applie', $contest->slug )}}" class="current btn-theme btn-small">Apply for this contest</a></li>
				@endif
					<li><a href="javascript:;" v-on:click="invite({{$contest->id}})" class="current btn-theme btn-small">Invite others friends! <i class="fa fa-facebook-square"></i></a></li>
				</ul>
			</nav>
		</div>
		<!-- Mensaje de concurso terminado -->
		@if($contest->end <= date('Y-m-d'))
        	<div class="row">
        		<div class="col-lg-8 col-lg-offset-2">
        			<div class="alert alert-danger">
        			<p><strong>This contest finished at {!! $contest->end !!}</strong></p>
        		</div>
        		</div>
        	</div>
         @endif
         <!-- /Mensaje de concurso terminado -->
         <!-- Mensaje de Session-->
         @if(Session::has('message'))
        	<div class="row">
        		<div class="col-lg-8 col-lg-offset-2">
        			<div class="alert alert-danger">
        			<p><strong>{!! Session::get('message') !!}</strong></p>
        		</div>
        		</div>
        	</div>
         @endif
         <!--/Mensaje de Session-->
         <!-- Messageip-->
		<div class="row" v-if="messageip.show">
        		<div class="col-lg-8 col-lg-offset-2">
        			<div v-bind:class="[messageip.type]">
        			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<p><strong>@{{ messageip.text }}</p>
        			</div>
        		</div>
            </div>
          <!--/Messageip -->
          <!-- Mensaje de voto realizado-->
		<div class="row" v-if="message.show">
        		<div class="col-lg-8 col-lg-offset-2">
        			<div v-bind:class="[message.type]">
        			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<p><strong>@{{ message.text }}</p>
        			</div>
        		</div>
            </div>
          <!--/Mensaje de voto realizado-->
          <!-- Concursantes -->
		<div class="row flat" v-cloak>
			<div class="col-lg-3 col-md-3 col-xs-6" v-for="contestant in contestants">
				<ul class="plan plan2">
					<li class="plan-name">@{{ contestant.user.name }}</li>
					<figure><img v-bind:src="contestant.photo" alt=""></figure>
					<li><strong>@{{ contestant.description }}</strong></li>
					<li><strong>Total votes: @{{ contestant.total_votes }} <i class="fa fa-arrow-up"></i></strong></li>
					<li style="color: red;" v-if="contestant.banned">BANNED <i class="fa fa-ban"></i></li>
					<li class="plan-action">
						<a  v-if="!contestant.banned && vote" v-on:click="vote(contestant)" class="btn">
							<span v-if="contestant.voting">Voting...</span>
							<span v-else>Vote</span>
						</a> <!-- Boton que se muestra si eñ visitante habilitado para votar en este concurso -->
						<button v-else class="btn" disabled="">Vote</button> <!-- Boton que se muestra cuando el visitante ya voto en este concurso -->
					</li>
				</ul>
			</div>
		</div>
		<!-- Consursantes -->
	</section>
@endsection

@section('js')
	<script type="text/javascript">

		Vue.http.headers.common['X-CSRF-TOKEN'] = "{!! csrf_token() !!}";

		var id = {!! $contest->id !!};

		new Vue({
			el: '#app',
			data: {
				contestants: [],
				vote: true,	//Cuando se verifique la ip, esta propiedad cambiará a FALSE, inhabilitando los botones  de votar
				messageip: {show: false, text: '', tipe: ''},  //Propiedades del mensaje que mostrara cuando ya el visitante voto
				message: {show: false, text: '', tipe: ''},  //Propiedades del mensaje que mostrara cuando ya el visitante voto
				},
			mounted: function(){
				this.getContestants();
				this.verifyIp();
			},
			methods:{
				getContestants: function(){ //Funcion que carga los participantes
					this.$http.get('/contestants/'+id).then(function(response){
							
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
					this.$http.get('/verifyIp/'+id).then(function(response){
							var data = response.body;
							if(data.canVote == false){
								this.vote = false; //Si el visitante ya voto, de seabilitan los botones de votar
								/*Mostramos un mensaje de que ya votó*/
								this.messageip.text = "You already votes in this contest from this computer!";
								this.messageip.type = "alert alert-warning";
								this.messageip.show = true;
							}
					});			
				},
				vote: function(contestant){
					this.$http.post('/votes/save', {id: id, contestant_id: contestant.id}).then(function(response){
							var data = response.body;
							if(data.vote == true){
								contestant.total_votes ++;
								this.message.text = "Congratulations, yo voted in this contest for " + contestant.user.name;
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
