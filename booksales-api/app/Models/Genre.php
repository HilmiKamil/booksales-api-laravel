<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    //
    private $genres = [
        [
            'id' => 1,
            'name' => 'Fiksi',
            'description' => 'Cerita yang bersifat imajinatif dan tidak nyata.'
        ],
        [
            'id' => 2,
            'name' => 'Self Improvement',
            'description' => 'Buku yang membantu pengembangan diri.'
        ],
        [
            'id' => 3,
            'name' => 'Manga',
            'description' => 'Komik khas Jepang dengan berbagai genre cerita.'
        ],
        [
            'id' => 4,
            'name' => 'Fantasy',
            'description' => 'Cerita dengan unsur sihir, dunia lain, dan makhluk fantasi.'
        ],
        [
            'id' => 5,
            'name' => 'Mystery',
            'description' => 'Cerita penuh teka-teki dan penyelidikan.'
        ]
    ];

    public function getGenres()
    {
        return $this->genres;
    }
}
