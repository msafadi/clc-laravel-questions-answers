<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tags')->insert([
            'name' => 'PHP',
            'slug' => Str::slug('PHP'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
