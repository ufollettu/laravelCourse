<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        // withCount('photos') cerca il metodo photo() nel model dell'Album per le relazioni
        // è l'equivalente di 'SELECT count(*) from photos'
        // with() invece restituisce tutta la collection delle photo relative
        $queryBuilder = Album::orderBy('id', 'DESC')->withCount('photos');
        if ($request->has('id')) {
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', '%' . $request->input('album_name') . '%');
        }
        $albums = $queryBuilder->get();
        return view('albums.albums', ['albums' => $albums]);
    }

    // Type hinting, laravel cerca in automatico l'id del tipo Album
    public function delete(Album $album)
    {
        // Eloquent
        // $res = Album::where('id', $id)->delete();
        // return $res;

        // Oppure
        // $res = Album::find($id)->delete();

        // Oppure con il Type hinting non serve usare find()
        $thumbnail = $album->album_thumb;
        // config è un helper che richiama le variabili di configuarazione presenti
        $disk = config('filesystems.default');
        $res = $album->delete();

        // per eliminare anche il file thumb dal disco
        if ($res) {
            if ($thumbnail && Storage::disk($disk)->has($thumbnail)) {
                Storage::disk('public')->delete($thumbnail);
            }
        }
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
        $album->user_id = 1;
        $this->processFile($id, $req, $album);
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
        $album = new Album();
        return view('albums.create', ['album' => $album]);
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
        $album->album_thumb = '';
        $album->description = request()->input('description');
        $album->user_id = 1;

        $res = $album->save();
        if ($res) {
            if ($this->processFile($album->id, request(), $album)) {
                $album->save();
            }
        }

        // QB
        // $res = DB::table('albums')->insert(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'user_id' => 1,
        //     ]
        // );

        $name = request()->input('name');
        $msg = $res ? 'Album ' . $name . ' creato' : 'album non creato';
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
    // & prima del parametro vuoldire passare come riferimento
    public function processFile($id, Request $req, &$album): bool
    {

        if (!$req->hasFile('album_thumb')) {
            return false;
        }

        $file = $req->file('album_thumb');

        if (!$file->isValid()) {
            return false;
        }
        // $filename = $file->store(env('ALBUM_THUMB_DIR')); // prende il nome e il percorso di default
        $filename = '/' . $id . '.' . $file->extension();
        $file->storeAs(env('ALBUM_THUMB_DIR'), $filename); // con nome custom
        $album->album_thumb = env('ALBUM_THUMB_DIR') . $filename;

        return true;
    }

    public function getImages(Album $album)
    {
        $images = Photo::where('album_id', $album->id)->latest()->paginate(10);
        // compact() serve a passare in maniere compatta le variabili alla vista
        return view('images.albumimages', compact('album', 'images'));
    }
}
