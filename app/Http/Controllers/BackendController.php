<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contest;
use App\Contestant;
use App\SocialAccount;
class BackendController extends Controller
{
    
    public function index(){

    	$totalAccounts = SocialAccount::all()->count();
    	$totalConstests = Contest::all()->count();
    	$totalConstestants = Contestant::all()->count();

    	return view('admin.index', compact('totalAccounts', 'totalConstests', 'totalConstestants'));	
    }

    public function contestants(){

    	return view('admin.contestants.index');
    }

    public function contests(){

    	return view('admin.contests.index');
    }

    
}
