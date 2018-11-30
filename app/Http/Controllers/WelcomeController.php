<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller {
    // Request $req ----> injection di Request nel metodo welcome
    public function welcome($name = '', $lastname = '', $age = 0, Request $req) {

        // si usa input come metodo della req per passare un parametro in URL tipo '?lang=eng'
        $language = $req->input('lang');

        $res = '<h1>hello admin ' .$name. ' ' .$lastname. ' ' .$age. ' your language is ' .$language. '</h1>';

        return $res;
    }
}
