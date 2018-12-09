<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('images.editimage', compact('photo'));
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
        // dd($request->only(['name', 'description']));
        $this->processFile($photo);
        $photo->album_id = $request->album_id;
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $res = $photo->save();

        $msg = $res ? 'Photo ' . $photo->name . ' modificata' : 'photo non modificata';
        session()->flash('message', $msg);
        return redirect()->route('photos.index');
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
        // $filename = $file->store(env('ALBUM_THUMB_DIR')); // prende il nome e il percorso di default
        $filename = $photo->id . '.' . $file->extension();
        $file->storeAs(env('IMG_DIR') . '/' . $photo->album_id, $filename); // con nome custom
        $photo->img_path = env('IMG_DIR') . $photo->album_id . '/' . $filename;

        return true;
    }
}
