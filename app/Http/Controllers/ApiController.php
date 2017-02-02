<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contest;
use App\Contestant;
use App\Vote;

class ApiController extends Controller
{
    public function getContestants($contest_id, Request $request){

    	if($request->ajax()){
            //Obtener un listados de participantes en este concurso
    		$contestants = Contestant::with('user')
    								->where('contest_id', $contest_id)
    								->orderBy('total_votes', 'DESC')->get();

    		return response()->json($contestants);	
    	}

    	return abort(404);

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
