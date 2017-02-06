<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contest;
use App\Contestant;
use App\Vote;
use Validator;
use Auth;
use Session;

class FrontendController extends Controller
{
    public function index(){

    	return view('index');
    }

    public function contests(){

    	$contests = Contest::where('start', '<=', date('Y-m-d'))->get();

    	return view('contests.index', compact('contests'));
    }

    public function showContest($slug, Request $request){ 

    	$contest = Contest::where('slug', $slug)->get();

        $winner = Contestant::where('contest_id', $contest[0]->id)
                                    ->orderBy('total_votes', 'DESC')->firstOrfail();

        if(count($contest) > 0){

    	return view('contests.show', compact('contest', 'winner'));

        }

        return abort(404);
    }

    public function applieContest($slug){ //Funcion que muestra el formulario para concursar

        $contest = Contest::where('slug', $slug)->get();

        return view('contests.applie', compact('contest'));
    }

    public function saveApplie($id, Request $request){

        //Validar si aun es posible consursar

        $contest = Contest::find($id); 

        $RegisterContestants = Contestant::where('contest_id', $id)->count(); //Cantidad de concursantes inscritos

        if($RegisterContestants == $contest->max_contestants){ //Verificar si el concurso llego a su maximo de participantes

                return redirect()->route('contest.show', $contest->slug);

        }else{
            //validamos el formulario
            $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'captcha' => 'required|captcha'
            ]);

             if ($validator->fails()) {
                return redirect()->route('contest.applie', $contest->slug)
                            ->withErrors($validator)
                            ->withInput();
            }

            //Validar que el concurso no este cerrado

            // Validar que el usuario no este concursando
            $verifyContestant = Contestant::where('user_id', Auth::user()->id)->where('contest_id', $id)->get();

            if(count($verifyContestant) > 0){

                Session::flash('message', "You're already register in this contest, you can't apply again!");

                return redirect()->route('contest.applie', $contest->slug);

            }

            $directory = '/frontend/images/contests/1';
            $imgName = $id.'_'.trim(Auth::user()->name).'.'.$request->photo->getClientOriginalExtension();
            $photo = $directory.'/'.$imgName;

            //Guardamos el concursante

            $contestant = new Contestant;
            $contestant->user_id = Auth::user()->id;
            $contestant->contest_id = $id;
            $contestant->photo = $photo;
            $contestant->description = $request->input('description');
            $save_contestant = $contestant->save();

            if (!$save_contestant) {
                
                return abort(500);
            }

            //Guardamos la imagen

            $request->photo->move(public_path($directory), $imgName);


            return redirect()->route('contest.show', $contest->slug);
        }
        
    }

     public function verifyIp($id, Request $request){

        if($request->ajax()){

            $ip = getIp();
            //Verificamo si la ip del visitante ya voto en este concurso
            $verify = Vote::where('contest_id', $id)->where('voter_ip', $ip)->get();

            if(count($verify) > 0){
                return response()->json(array('canVote' => false));
            }else{
                return response()->json(array('canVote' => true));
            }

            return getIp(); 
        }
        return abort(404);
    }

    public function vote(Request $request){

        if($request->ajax()){

            $ip = getIp();
            //Registrar el votante
            $vote = new Vote;
            $vote->contest_id = $request->input('id');
            $vote->contestant_id = $request->input('contestant_id');
            $vote->voter_ip = $ip;
            $save_vote = $vote->save();

            //Actualizar el voto en el participante

            $contestant = Contestant::find($request->input('contestant_id'));
            $contestant->total_votes =  $contestant->total_votes + 1;
            $save_contestant = $contestant->save();

            if (!$save_vote OR !$save_contestant) {
                
                return response()->json(array('vote' => false));

            }else{

                return response()->json(array('vote' => true));
            }

            

        }

        return abort(404);
    }
}
