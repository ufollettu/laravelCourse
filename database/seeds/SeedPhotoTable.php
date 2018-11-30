<?php

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
        $photos = factory(App\Models\Photo::class, 300)->create();
    }
}
