<?php


use Phinx\Seed\AbstractSeed;

class FillCommentsTable extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function getDependencies()
    {
        return [
            'FillPostsTable',
            'FillUsersTable'
        ];
    }

    public function run()
    {

        $faker = \Faker\Factory::create();
        $comments = [];

        for ($i = 1; $i < 26 ; ++$i ) {
            for ($y = 0; $y < 2 ; ++$y ) {
                $timestamp = $faker->unixTime('now');

                $comments[] = [
                    'post_id' => $i,
                    'user_id' => rand(1, 11),
                    'content' => $faker->sentence(15),
                    'is_confirmed' => rand(0, 1),
                    'created_at' => date('Y-m-d H:i:s', $timestamp),
                    'updated_at' => date('Y-m-d H:i:s', $timestamp),
                    'is_deleted' => rand(0, 1)
                ];

            }
        }

        $this->insert('comments', $comments);
    }
}
