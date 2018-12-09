<?php

namespace App\Models;

use App\Models\Album;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = ['name', 'img_path', 'description'];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function getPathAttribute()
    {
        $url = $this->img_path;
        if (stristr($url, 'http') === false) {
            $url = 'storage/' . $url;
        }
        return $url;
    }

    // [get] metodo accessor: da l'accesso a un nuovo parametro photo->img_path
    // prima che venga ritornata in una vista
    public function getImgPathAttribute($value)
    {
        if (stristr($value, 'http') === false) {
            $value = 'storage/' . $value;
        }
        return $value;
    }

    // [set] metodo mutator, per fare operazioni sul valore passato
    // prima di settarlo e inviarlo al DB
    // in questo caso il valore di photo->name diventa tutto maiuscolo
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtoupper($value);
    }
}
