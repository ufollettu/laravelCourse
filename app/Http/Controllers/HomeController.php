<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController {
    public function index(Request $req) {
        return 'hello home' .$req->input('name');
    }
}
