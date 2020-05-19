<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class FillPostsTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $posts = [];

        for ($i = 0; $i < 10 ; ++$i ) {
            $timestamp = $faker->unixTime('now');
            $content = '<p>' . $faker->text(200) . '</p>' . '<p>' . $faker->text(800) . '</p>' . '<p>' . $faker->text(400) . '</p>';

            $posts[] = [
                'name' => $faker->sentence(6),
                'picture' => '',
                'catchphrase' => $faker->sentence(24),
                'content' => $content,
                'created_at' => date('Y-m-d H:i:s', $timestamp),
                'updated_at' => date('Y-m-d H:i:s', $timestamp),
                'is_deleted' => rand(0, 1)
            ];
        }

        $this->insert('posts', $posts);
    }
}
