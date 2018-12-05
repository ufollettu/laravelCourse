<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        // return Album::All();

        // Raw queries
        // $sql = 'select * from albums where 1=1';
        // $where = [];
        // if ($request->has('id')) {
        //     $where['id'] = $request->get('id');
        //     $sql .= " AND ID=:album_name";
        // }
        // if ($request->has('album_name')) {
        //     $where['album_name'] = $request->get('album_name');
        //     $sql .= " AND album_name=:album_name";
        // }
        // dd() dynamic dump utile per stampare le query a schermo
        // dd($sql);
        // return DB::select($sql, $where);
        // $sql .= ' ORDER BY id desc ';
        // $albums = DB::select($sql, $where);

        // Laravel QueryBuilder ritorna sempre un querybuilder che si può concatenare con i metodi
        // $queryBuilder = DB::table('albums')->orderBy('id', 'DESC');

        // if ($request->has('id')) {
        //     $queryBuilder->where('id', '=', $request->input('id'));
        // }
        // if ($request->has('album_name')) {
        //     $queryBuilder->where('album_name', 'like', '%' . $request->input('album_name') . '%');
        // }
        // $albums = $queryBuilder->get();
        // return view('albums.albums', ['albums' => $albums]);

        // Eloquent (che usa i model) il primo metodo deve essere statico
        $queryBuilder = Album::orderBy('id', 'DESC');
        if ($request->has('id')) {
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', '%' . $request->input('album_name') . '%');
        }
        $albums = $queryBuilder->get();
        return view('albums.albums', ['albums' => $albums]);
    }

    public function delete($id)
    {
        // Eloquent
        // $res = Album::where('id', $id)->delete();
        // return $res;

        // Oppure
        $res = Album::find($id)->delete();
        // bisogna concatenare una stringa perchè delete() ritorna true
        // mentre la response deve essere stringa
        return ' ' . $res;

        // QueryBuilder
        // $res = DB::table('albums')->where('id', $id)->delete();
        // return $res;

        // Raw
        // $sql = 'DELETE FROM albums WHERE id= :id';
        // return DB::delete($sql, ['id' => $id]);
    }

    public function show($id)
    {
        $res = DB::table('albums')->where('id', $id)->get();
        return $res;

        // Raw
        // $sql = 'SELECT * FROM albums WHERE id= :id';
        // return DB::select($sql, ['id' => $id]);
    }

    public function edit($id)
    {
        $album = Album::find($id);
        return view('albums.edit')->with('album', $album);

        // Raw
        // $sql = 'SELECT id, album_name, description FROM albums WHERE id= :id';
        // $album = DB::select($sql, ['id' => $id]);
        // return view('albums.edit')->with('album', $album[0]);
    }

    public function store($id, Request $req)
    {
        // Eloquent
        // $res = Album::where('id', $id)->update(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //     ]
        // );

        // Oppure
        $album = Album::find($id);
        $album->album_name = request()->input('name');
        $album->description = request()->input('description');
        $res = $album->save();

        // QueryBuilder
        // $res = DB::table('albums')->where('id', $id)->update(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //     ]
        // );

        $msg = $res ? 'album con id ' . $id . ' aggiornato' : 'album non aggiornato';
        session()->flash('message', $msg);
        return redirect()->route('albums');

        // Raw
        // $data = request()->only(['name', 'description']);
        // $data['id'] = $id;
        // $sql = 'UPDATE albums SET album_name =:name, description =:description ';
        // $sql .= ' WHERE id =:id';
        // $res = DB::update($sql, $data);
        // $msg = $res ? 'album con id ' . $id . ' aggiornato' : 'album non aggiornato';
        // session()->flash('message', $msg);
        // return redirect()->route('albums');
    }

    public function create()
    {
        return view('albums.create');
    }

    public function save()
    {

        // Eloquent
        // $res = Album::insert(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'user_id' => 1,
        //     ]
        // );

        // Oppure
        // $res = Album::create(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'user_id' => 1,
        //     ]
        // );
        // Oppure
        $album = new Album();
        $album->album_name = request()->input('name');
        $album->description = request()->input('description');
        $album->user_id = 1;

        $res = $album->save();

        // QB
        // $res = DB::table('albums')->insert(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'user_id' => 1,
        //     ]
        // );

        $msg = $res ? 'Album ' . request()->input('name') . ' creato' : 'album non creato';
        session()->flash('message', $msg);
        return redirect()->route('albums');

        // $data = request()->only(['name', 'description']);
        // $data['user_id'] = 1;
        // $sql = 'INSERT INTO albums (album_name, description, user_id)';
        // $sql .= ' VALUES(:name, :description, :user_id) ';
        // $res = DB::insert($sql, $data);
        // $msg = $res ? 'Album ' . $data['name'] . ' creato' : 'album non creato';
        // session()->flash('message', $msg);
        // return redirect()->route('albums');
    }
}
