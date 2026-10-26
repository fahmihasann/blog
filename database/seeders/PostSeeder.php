<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 25; $i++) {
            Post::Create ([
                'title' => ucfirst($faker->sentence(4)),
                'content' => $faker->paragraphs(3, true),
            ]);
        }
    }
}
