<?php

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class SeedPhotoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $albums = Album::get();
        foreach ($albums as $album) {
            $photos = factory(App\Models\Photo::class, 300)->create(
                ['album_id' => $album->id]
            );
        }
    }
}
