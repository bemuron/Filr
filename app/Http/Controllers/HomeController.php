<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $res = DB::table('files')//SHOW SERVER STATUSG
        //     ->select(DB::raw("SHOW SERVER STATUSG"))
        //     ->first();

        // dd($res);
        return view('home');
    }
}
