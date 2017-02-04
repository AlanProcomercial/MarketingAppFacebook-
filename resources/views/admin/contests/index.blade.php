@extends('layouts.baseBackend')

@section('page')
Contest list
@endsection

@section('header')
Contest list
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div v-if="msg.show" v-bind:class="[msg.class]">
            <button type="button" class="close" data-dismiss="alert" v-on:click="msg.show == false" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                @{{ msg.text }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Data of the Contests
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Descripction</th>
                            <th>Max</th>
                            <th>Users</th>
                            <th>Total votes</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contest, index) in contests" v-cloak>
                                <td>@{{ contest.id }}</td>
                                <td v-if="!contest.editing">@{{ contest.name }}</td>
                                <td v-else>
                                    <input type="text" class="form-control" v-model="contest.name" size="4">
                                </td>
                                <td v-if="!contest.editing">@{{ contest.description }}</td>
                                <td v-else>
                                    <input type="text" class="form-control" v-model="contest.description">
                                </td v-else>
                                <td v-if="!contest.editing">@{{ contest.max_contestants }}</td>
                                <td v-else>
                                     <input type="text" class="form-control" v-model="contest.max_contestants" size="1">
                                </td>
                                <td class="text-center">@{{ contest.total_contestants }}</td>
                                <td class="text-center">@{{ contest.total_votes }}</td>
                                <td v-if="!contest.editing" class="text-center">@{{ contest.start }}</td>
                                <td v-else>
                                     <input type="text" class="form-control" v-model="contest.start" size="3">
                                </td>
                                <td v-if="!contest.editing" class="text-center">@{{ contest.end }}</td>
                                <td v-else>
                                     <input type="text" class="form-control" v-model="contest.end" size="3">
                                </td>
                            <td class="text-center">
                            <!-- Boton para editar concurso-->
                                <button 
                                    v-if="!contest.editing"
                                    v-on:click="edit(contest)" 
                                    title="Edit" 
                                    class="fa fa-pencil-square-o btn btn-primary btn-xs">
                                </button>
                               <!--/ Boton para editar concurso-->
                               <!-- Boton para actualizar el concurso-->
                                <button 
                                    v-else
                                    v-on:click="update(contest)" 
                                    title="Save" 
                                    class="fa fa-save btn btn-primary btn-xs">
                                </button>
                                <!-- /Boton para actualizar el concurso-->
                               <!-- Boton para cancelar edicion-->
                                <button 
                                    v-if="contest.editing"
                                    v-on:click="contest.editing = false" 
                                    title="Cancel edit" 
                                    class="fa fa-times-o btn btn-danger btn-xs">X
                                </button>
                               <!-- /Boton para cancelar edicion-->
                                </td>
                        </tr>
                    </tbody>
                </table>
                <ul class="pager">
                    <li class="previous" v-show="pagination.previous">
                        <a style="cursor: pointer;" class="page-scroll" v-on:click="getContestsPaginate('previous')">Previous</a>
                    </li>
                    <li class="next" v-show="pagination.next">
                        <a style="cursor: pointer;"  class="page-scroll" v-on:click="getContestsPaginate('next')">Next</a>
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
                contests: [],
                pagination:{
                    page: 1,
                    previous: false,
                    next: false 
                },
                msg: {
                    show: false, 
                    text: '', 
                    class: ''}
            },
            mounted: function(){
                this.getContestsPaginate();
            },
            methods:{
                getContestsPaginate: function(direction){

                    if (direction === 'previous'){
                        --this.pagination.page;
                    }
                    else if (direction === 'next'){
                        ++this.pagination.page;
                    }

                    this.$http.get('/contests/all?page='+this.pagination.page).then(function(response){
                        this.contests = [];
                        for (var i = 0 ; i < response.body.length; i++) {
                                var data = response.body;
                                this.contests.push(data[i]);
                            };
                        this.pagination.next = response.body.next_page_url;
                        this.pagination.previous = response.body.prev_page_url;                     
                    });
                },
                edit: function(contest){
                    Vue.set(contest, 'editing', true);
                },
                update: function(contest){
                    var data = {name: contest.name, 
                                description: contest.description,
                                max_contestants: contest.max_contestants,
                                start: contest.start,
                                end: contest.end};

                    this.$http.put('/contests/'+contest.id, data).then(function(response){
                        var data = response.body;
                        if(data.update == true){
                            Vue.set(contest, 'editing', false);
                            this.msg.class = 'alert alert-success';
                            this.msg.text = 'The contest update successfull!';
                            this.msg.show = true;
                        }else{
                            this.msg.class = 'alert alert-danger';
                            this.msg.text = 'Error!';
                            this.msg.show = true;
                        }
                    });
                }
            } 
        });
    </script>
@endsection
