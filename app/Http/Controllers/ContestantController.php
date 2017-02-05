<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contest;
use App\Contestant;
use App\Vote;

class ContestantController extends Controller
{
    public function getAllInContest($contest_id, Request $request){

    	if($request->ajax()){
            //Obtener un listados de tofos los participantes en este concurso
    		$contestants = Contestant::with('user', 'contest')
    								->where('contest_id', $contest_id)
    								->orderBy('total_votes', 'DESC')->get();

    		return response()->json($contestants);	
    	}

    	return abort(404);
    }

    public function getAll(Request $request){

    	if($request->ajax()){
            //Obtener un listados de todos los participantes 
    		$contestants = Contestant::with('user', 'contest')
    								->orderBy('id', 'ASC')->paginate(10);

    		return response()->json($contestants);	
    	}

    	return abort(404);
    }

    public function delete($id, Request $request){

        if($request->ajax()){
            
            $contestant = Contestant::find($id);
            $contestant->delete();

            return response()->json(array('deleted', true));  
        }

        return abort(404);
    }

    public function updateVote(Request $request, $id){

        if($request->ajax()){
            $contestants = Contestant::find($id);
            $contestants->total_votes = $request->input('vote');
            $save = $contestants->save();

            if(!$save){

                return response()->json(array('update' => false));
            }

            return response()->json(array('update' => true));  
        }

        return abort(404);

    }

    public function updateBan(Request $request, $id){

        if($request->ajax()){
            $contestants = Contestant::find($id);
            $contestants->banned = $request->input('ban');
            $save = $contestants->save();

            if(!$save){

                return response()->json(array('update' => false));
            }

            return response()->json(array('update' => true));  
        }

        return abort(404);

    }

    public function filterResults(Request $request){

        if ($request->ajax()) {

            if($request->input('type') == 'email'){
                $type = 'email';
            }else{
                $type = 'name';
            }

            $data = array('type' => $type, 'search' => $request->input('search'));

            $contestants = Contestant::with('user', 'contest')
                                        ->whereHas('user', function($q) use ($data){
                                        $q->where($data['type'], 'like','%'.$data['search'].'%');
                                    })->orderBy('id', 'ASC')->paginate(10);

            return response()->json($contestants);
        }

        return abort('404');
    }

}
