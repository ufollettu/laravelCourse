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
}
