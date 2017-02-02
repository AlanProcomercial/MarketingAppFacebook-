<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function contest(){
    	
        return $this->belongsTo('App\Contest');
    }

    public function contestant(){

        return $this->belongsTo('App\Contestant');
    }
}
