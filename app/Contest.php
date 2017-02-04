<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    public function contestants(){

    	return $this->hasMany('App\Contestant');

    }
}
