<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = new \App\Tag();
        $tag->name = "Tutorials";
        $tag->save();

        $tag = new \App\Tag();
        $tag->name = "Other";
        $tag->save();
    }
}
