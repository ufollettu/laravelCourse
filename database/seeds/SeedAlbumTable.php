<?php

use App\Models\Album;
use Illuminate\Database\Seeder;

class SeedAlbumTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $albums = factory(App\Models\Album::class, 30)->create();
    }
}
