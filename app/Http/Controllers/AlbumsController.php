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
        // return DB::select($sql, $where);
        $albums = DB::select($sql, $where);
        return view('albums.albums', ['albums' => $albums]);

    }

    public function delete($id)
    {
        $sql = 'DELETE FROM albums WHERE id= :id';
        return DB::delete($sql, ['id' => $id]);
    }

    public function show($id)
    {
        $sql = 'SELECT * FROM albums WHERE id= :id';
        return DB::select($sql, ['id' => $id]);
    }

    public function edit($id)
    {
        $sql = 'SELECT id, album_name, description FROM albums WHERE id= :id';
        $album = DB::select($sql, ['id' => $id]);
        return view('albums.edit')->with('album', $album[0]);
    }

    public function store($id, Request $req)
    {
        $data = request()->only(['name', 'description']);
        $data['id'] = $id;

        $sql = 'UPDATE albums SET album_name =:name, description =:description ';
        $sql .= ' WHERE id =:id';
        $res = DB::update($sql, $data);
        $msg = $res ? 'album con id ' . $id . ' aggiornato' : 'album non aggiornato';
        session()->flash('message', $msg);
        return redirect()->route('albums');
    }
}
