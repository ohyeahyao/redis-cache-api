<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->makeLanguage();
        $this->makeTutors();
        $this->makeTutorsPrice();
        $this->makeTutorsLanguage();
    }

    private function makeTutorsLanguage()
    {
        $tutor_language_array = [
            [
                'tutor_id' => 1,
                'language_id' => 2,
            ],
            [
                'tutor_id' => 2,
                'language_id' => 3,
            ],
            [
                'tutor_id' => 3,
                'language_id' => 1,
            ],
            [
                'tutor_id' => 4,
                'language_id' => 1,
            ]
        ];
        DB::table('tutor_languages')->insert($tutor_language_array);
    }

    private function makeTutorsPrice()
    {
        $lesson_price_array = [
            [
                'tutor_id' => 1,
                'trial_price' => 100,
                'normal_price' => 200,
            ],
            [
                'tutor_id' => 2,
                'trial_price' => 200,
                'normal_price' => 400,
            ],
            [
                'tutor_id' => 3,
                'trial_price' => 10,
                'normal_price' => 50,
            ],
            [
                'tutor_id' => 4,
                'trial_price' => 1000,
                'normal_price' => 2000,
            ]
        ];
        DB::table('tutor_lesson_prices')->insert($lesson_price_array);
    }

    private function makeTutors()
    {
        $faker = Faker::create();
        $tutors_array = [
            [
                'id' => 1,
                'slug' => 'tc-jiyao',
                'name' => 'Teacher Ji',
                'headline' => 'Hi! I am Ji',
                'introduction' => $faker->text($maxNbChars = 200)
            ],
            [
                'id' => 2,
                'slug' => 'jp-ling',
                'name' => 'Teacher Ling',
                'headline' => 'Hi! I am Ling',
                'introduction' => $faker->text($maxNbChars = 200)
            ],
            [
                'id' => 3,
                'slug' => 'en-ohyeahyao',
                'name' => 'Teacher Yao',
                'headline' => 'Hi! I am Yao',
                'introduction' => $faker->text($maxNbChars = 200)
            ],
            [
                'id' => 4,
                'slug' => 'en-mika',
                'name' => 'Teacher Mika',
                'headline' => 'Hi! I am Mika',
                'introduction' => $faker->text($maxNbChars = 200)
            ]
        ];
        DB::table('tutors')->insert($tutors_array);
    }

    private function makeLanguage()
    {
        $language_array = [
            ['id'=>1, 'slug' => 'english'],
            ['id'=>2, 'slug' => 'chinsese'],
            ['id'=>3, 'slug' => 'japanese']
        ];

        DB::table('languages')->insert($language_array);
    }
}
