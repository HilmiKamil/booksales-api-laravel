<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Book::create([
            'title' => 'Harry Potter and the Sorcerers Stone',
            'description' => 'The first book in the Harry Potter series.',
            'price' => 25000,
            'stock' => 37,
            'cover_photo' => 'harry_potter.jpg',
            'genre_id' => 1,
            'author_id' => 1
        ]);

        Book::create([
            'title' => 'The Lord of the Rings',
            'description' => 'A classic fantasy novel.',
            'price' => 60000,
            'stock' => 30,
            'cover_photo' => 'the_lord_of_the_rings.jpg',
            'genre_id' => 1,
            'author_id' => 2
        ]);

        Book::create([
            'title' => '1984',
            'description' => 'A dystopian novel with futuristic themes.',
            'price' => 40000,
            'stock' => 40,
            'cover_photo' => '1984.jpg',
            'genre_id' => 3,
            'author_id' => 3
        ]);

        Book::create([
            'title' => 'The Devotion of Suspect X',
            'description' => 'A mystery novel by Keigo Higashino.',
            'price' => 55000,
            'stock' => 25,
            'cover_photo' => 'suspect_x.jpg',
            'genre_id' => 2,
            'author_id' => 4
        ]);

        Book::create([
            'title' => 'Sherlock Holmes A Study in Scarlet',
            'description' => 'A detective novel introducing Sherlock Holmes.',
            'price' => 70000,
            'stock' => 30,
            'cover_photo' => 'sherlock_holmes.jpg',
            'genre_id' => 1,
            'author_id' => 5
        ]);
    }
}
