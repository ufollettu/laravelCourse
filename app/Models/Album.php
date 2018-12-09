<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';
    protected $primaryKey = 'id';

    protected $fillable = ['album_name', 'description', 'user_id'];

    // per creare una proprietà da utilizzare fuori dal modello
    // si crea un metodo così: "get + Nome_proprietà + Attribute"
    // si richiamerà così: $album->nome_proprietà
    public function getPathAttribute()
    {
        $url = $this->album_thumb;
        if (stristr($url, 'http') === false) {
            $url = 'storage/' . $this->album_thumb;
        }
        return $url;
    }

    // relazioni in Laravel
    public function photos()
    {
        // 1 a N
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }
}
