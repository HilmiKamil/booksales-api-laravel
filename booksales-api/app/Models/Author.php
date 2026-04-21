<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    private $authors = [
        [
            'id' => 1,
            'name' => 'J.K. Rowling',
            'photo' => 'jk_rowling.jpg',
            'bio' => 'British author, best known for the Harry Potter series.'
        ],
        [
            'id' => 2,
            'name' => 'George R.R. Martin',
            'photo' => 'george_rr_martin.jpg',
            'bio' => 'American novelist and short story writer, known for A Song of Ice and Fire.'
        ],
        [
            'id' => 3,
            'name' => 'Isaac Asimov',
            'photo' => 'isaac_asimov.jpg',
            'bio' => 'American author and professor of biochemistry, known for his works in science fiction.'
        ],
        [
            'id' => 4,
            'name' => 'Keigo Higashino',
            'photo' => 'keigo_higashino.jpg',
            'bio' => 'Japanese author known for his mystery novels.'
        ],
        [
            'id' => 5,
            'name' => 'Arthur Conan Doyle',
            'photo' => 'arthur_conan.jpg',
            'bio' => 'British writer, creator of Sherlock Holmes.'
        ]
    ];

    public function getAuthors()
    {
        return $this->authors;
    }
}
