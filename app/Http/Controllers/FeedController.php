<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function __construct()
    {
        $this->middleware('auth');
    }
    public function feed()
    {
        return view('backEnd.feed.feed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
}
