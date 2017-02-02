<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contest;
use App\Contestant;
use Validator;
use Auth;
use Session;

class FrontendController extends Controller
{
    public function index(){

    	return view('index');
    }

    public function contests(){

    	$contests = Contest::all();

    	return view('contests.index', compact('contests'));
    }

    public function showContest($id, Request $request){ 

    	$contest = Contest::find($id);

        if(count($contest) > 0){

    	return view('contests.show', compact('contest'));

        }

        return abort(404);
    }

    public function applieContest($id){ //Funcion que muestra el formulario para concursar

        $contest = Contest::find($id);

        return view('contests.applie', compact('contest'));
    }

    public function saveApplie($id, Request $request){

        //Validar si aun es posible consursar

        $MaxcContestants = Contest::find($id); //Catidad maxima permitida

        $RegisterContestants = Contestant::where('contest_id', $id)->count(); //Cantidad de concursantes inscritos

        if($RegisterContestants == $MaxcContestants->max_contestants){ //Verificar si el concurso llego a su maximo de participantes

                return redirect()->route('contest.show', $id);

        }else{
            //validamos el formulario
            $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            ]);

             if ($validator->fails()) {
                return redirect()->route('contest.applie', $id)
                            ->withErrors($validator)
                            ->withInput();
            }

            // Validar que el usuario no este concursando
            $verifyContestant = Contestant::where('user_id', Auth::user()->id)->where('contest_id', $id)->get();

            if(count($verifyContestant) > 0){

                Session::flash('message', "You're already contestant in this contest, you can't apply again!");

                return redirect()->route('contest.applie', $id);

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


            return redirect()->route('contest.show', $id);
        }

        
        
    }
}
