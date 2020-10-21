<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // se uso la prima alternativa in web.php devo togliere il middleware qui, perché già è impostato di là
    // public function __construct() {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('admin.home');
    }
}
