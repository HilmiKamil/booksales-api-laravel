<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Genre::create([
            'name' => 'Fiction',
            'description' => 'A literary work based on the imagination and not necessarily on fact.'
        ]);


        Genre::create([
            'name' => 'Non-Fiction',
            'description' => 'A literary work based on facts and real events.'
        ]);

        Genre::create([
            'name' => 'Science Fiction',
            'description' => 'A genre that deals with imaginative and futuristic concepts.'
        ]);
    }
}
