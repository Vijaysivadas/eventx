<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
//        $events = Events::where('admin_id','=',auth()->user()->id);
//        $
        return view('dashboard');
    }
}
