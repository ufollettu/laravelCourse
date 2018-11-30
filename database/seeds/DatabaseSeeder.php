<?php

use App\Models\Album;
use App\Models\Photo;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// use Course\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Album::truncate();
        Photo::truncate();

        $this->call(SeedUserTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotoTable::class);
    }
}
