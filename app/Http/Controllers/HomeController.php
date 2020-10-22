<?php

namespace App\Http\Controllers;

class HomeController extends Controller {
    
    /**
     * R401: Home Page [/home]
     */
    public function list() {
        return view('pages.home');
    }

    public function home() {
        return redirect('home');
    }

}

?>