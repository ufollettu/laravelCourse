<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    protected $rules = [
        'album_id' => 'required',
        'name' => 'required',
        'description' => 'required',
        'img_path' => 'required|image',
    ];

    protected $errorMessages = [
        'album_id.required' => 'Il campo Album è obbligatorio',
        'description.required' => 'Il campo Descrizione è obbligatorio',
        'name.required' => 'Il campo Nome è obbligatorio',
        'img_path.required' => 'Il campo Immagine è obbligatorio',
    ];

    public function __construct()
    {
        // per proteggere tutte le rotte della classe
        $this->middleware('auth');
        // per proteggerne solo alcune
        // $this->middleware('auth')->only(['create', 'edit']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $id = $req->has('album_id') ? $req->input('album_id') : null;
        $album = Album::firstOrNew(['id' => $id]);
        $albums = $this->getAlbums();

        $photo = new Photo();
        return view('images.editimage', compact(['photo', 'album', 'albums']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules, $this->errorMessages);
        $photo = new Photo();
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input('album_id');
        $this->processFile($photo);
        $photo->save();
        return redirect(route('album.getimages', $photo->album_id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        dd($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $albums = $this->getAlbums();
        // si riferisce al modello belongsTo del model
        // va richiamato come proprietà, non come metodo
        $album = $photo->album;
        return view('images.editimage', compact(['photo', 'albums', 'album']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        $this->validate($request, $this->rules, $this->errorMessages);
        // dd($request->only(['name', 'description']));
        $this->processFile($photo);
        $photo->album_id = $request->album_id;
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $res = $photo->save();

        $msg = $res ? 'Photo ' . $photo->name . ' modificata' : 'photo non modificata';
        session()->flash('message', $msg);
        return redirect()->route('album.getimages', $photo->album_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();
        if ($res) {
            $this->deleteFile($photo);
        }

        return '' . $res;
        // return Photo::findOrFail($photo)->destroy($photo);
    }

    public function deleteFile(Photo $photo)
    {
        $disk = config('filesystems.default');
        if ($photo->img_path && Storage::disk()->has($photo->img_path)) {
            return Storage::disk($disk)->delete($photo->img_path);
        }

        return false;
    }

    public function processFile(Photo $photo, Request $req = null): bool
    {

        if (!$req) {
            $req = request();
        }
        if (!$req->hasFile('img_path')) {
            return false;
        }

        $file = $req->file('img_path');

        if (!$file->isValid()) {
            return false;
        }
        $imgName = preg_replace('@[a-z0-9]i@', '_', $photo->name);
        // $filename = $file->store(env('ALBUM_THUMB_DIR')); // prende il nome e il percorso di default
        $filename = $imgName . '.' . $file->extension();
        $file->storeAs(env('IMG_DIR') . '/' . $photo->album_id, $filename); // con nome custom
        $photo->img_path = env('IMG_DIR') . $photo->album_id . '/' . $filename;

        return true;
    }

    public function getAlbums()
    {
        return Album::orderBy('album_name')->get();
    }
}
