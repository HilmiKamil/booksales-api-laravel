<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Author::create([
            'name' => 'J.K. Rowling',
            'photo' => 'jk_rowling.jpg',
            'bio' => 'British author, best known for the Harry Potter series.'
        ]);

        Author::create([
            'name' => 'George R.R. Martin',
            'photo' => 'george_rr_martin.jpg',
            'bio' => 'American novelist and short story writer, known for A Song of Ice and Fire.'
        ]);

        Author::create([
            'name' => 'Isaac Asimov',
            'photo' => 'isaac_asimov.jpg',
            'bio' => 'American author and professor of biochemistry, known for his works in science fiction.'
        ]);

        Author::create([
            'name' => 'Keigo Higashino',
            'photo' => 'keigo_higashino.jpg',
            'bio' => 'Japanese author known for his mystery and detective novels such as The Devotion of Suspect X.'
        ]);

        Author::create([
            'name' => 'Arthur Conan Doyle',
            'photo' => 'arthur_conan.jpg',
            'bio' => 'British writer best known for creating the famous detective Sherlock Holmes.'
        ]);
    }
}
