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

    // RITORNARE UNA VIEW (3 MODI)
    public function about()
    {
        // 1 MODO
        return view('about');

        // 2 MODO
        // $view = app('view');
        // return $view('about');

        // 3 MODO (cpn make)
        // return view::make('about');
    }

    public function blog()
    {

        return view('blog');

    }

    // PASSARE DATI ALLE VIEW (4 MODI)
    public function staff()
    {

        // 1 MODO
        $staff = $this->data;
        $title = 'our staff';

        return view('staffb', compact('title', 'staff'));

        // 2 MODO (metodi magici eloquent)
        // return view('staff')
        //     ->withStaff($this->data)
        //     ->withTitle('our staff');

        // 3 MODO
        // return view('staff')
        //     ->with('staff', $this->data)
        //     ->with('title', 'our staff');

        // 4 MODO
        // return view('staff', ['title' => 'our staff', 'staff' => $this->data]);

    }
}
