<?php

namespace App\Http\Controllers;

use View;

class PageController extends Controller
{

    protected $data = [
        [
            'name' => 'pasquale',
            'lastname' => 'merolle',
        ],
        [
            'name' => 'pino',
            'lastname' => 'drudi',
        ],
        [
            'name' => 'gino',
            'lastname' => 'stascio',
        ],
    ];

    public function about()
    {

        return view('about');

        // $view = app('view');
        // return $view('about');

        // return view::make('about');
    }

    public function blog()
    {

        return view('blog');

    }

    public function staff()
    {

        return view('staff', ['title' => 'our staff', 'staff' => $this->data]);

    }
}
