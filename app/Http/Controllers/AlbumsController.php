<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        // return Album::All();

        // Raw queries
        $sql = 'select * from albums where 1=1';
        $where = [];
        if ($request->has('id')) {
            $where['id'] = $request->get('id');
            $sql .= " AND ID=:album_name";
        }
        if ($request->has('album_name')) {
            $where['album_name'] = $request->get('album_name');
            $sql .= " AND album_name=:album_name";
        }
        // dd() dynamic dump utile per stampare le query a schermo
        // dd($sql);
        return DB::select($sql, $where);

    }
}
