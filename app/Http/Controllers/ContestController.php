<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contest;
use App\Contestant;
use App\Vote;

class ContestController extends Controller
{
    public function getAll(Request $request){

    	if($request->ajax()){
            //Obtener un listados de todos los Concursos 
    		$contest = Contest::with('contestants')
    								->orderBy('id', 'ASC')->paginate(10);

    		$arrayContest = array();

    		foreach ($contest as $contest) {
    			
    			array_push($arrayContest, array('id' => $contest->id,
    											'name' => $contest->name,
    											'description' => $contest->description,
    											'max_contestants' => $contest->max_contestants,
    											'total_contestants' => count($contest->contestants),
    											'start' => $contest->start,
    											'end' => $contest->end,
    											'total_votes' => $contest->contestants->sum('total_votes')));
    		}

    		return response()->json($arrayContest);	
    	}

    	return abort(404);
    }

    public function update($id, Request $request){
		
			if($request->ajax()){
	     	
	    		$contest = Contest::find($id);
	    		$contest->name = $request->input('name');
	    		$contest->description = $request->input('description');
	    		$contest->max_contestants = $request->input('max_contestants');
	    		$contest->start = $request->input('start');
	    		$contest->end = $request->input('end');
	    		$save = $contest->save();

	    		if (!$save) {
	    			return response()->json(array('update' => FALSE));
	    		}

	    		return response()->json(array('update' => TRUE));
	    	}

	    	return abort(404);
	}	

}
