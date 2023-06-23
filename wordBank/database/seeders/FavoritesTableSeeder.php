<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
            'user_id' => 1,
            'word' => 'apple'
            ],
            [
            'user_id' => 1,
            'word' => 'banana'
            ],
            [
            'user_id' => 2,
            'word' => 'banana'
            ],
            [
            'user_id' => 2,
            'word' => 'work'
            ],
            [
            'user_id' => 3,
            'word' => 'chocolate'
            ],
            [
            'user_id' => 3,
            'word' => 'banana'
            ],
            [
            'user_id' => 3,
            'word' => 'hello'
            ],
                        [
            'user_id' => 4,
            'word' => 'apple'
            ],
            [
            'user_id' => 4,
            'word' => 'banana'
            ],
            [
            'user_id' => 3,
            'word' => 'planet'
            ],
            [
            'user_id' => 3,
            'word' => 'work'
            ],
            [
            'user_id' => 2,
            'word' => 'chocolate'
            ],
            [
            'user_id' => 1,
            'word' => 'hard'
            ],
            [
            'user_id' => 1,
            'word' => 'hello'
            ],

            // Add more data as needed...
        ];

        foreach ($data as $row) {
            if (!Favorite::where('user_id', $row['user_id'])->where('word', $row['word'])->exists()) {
                    Favorite::create($row);
            }
        }
    }
}