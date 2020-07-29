<?php


use Phinx\Seed\AbstractSeed;

class FillUsersTable extends AbstractSeed
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
        $admins = [];
        $users = [];

        $timestamp = $faker->unixTime('now');

        $admins = [
            [
                'name'    => 'Demo',
                'email'    => 'mailDeTest@mail.fr',
                'password'    => '$2y$10$k1nXQjZIgg/ZEqr7FKs8g.jNmydPkSYW6jCxURzi3tX.XWKUFQwYa',
                'token'    => 'qHn9ehA4akF4uqcA9SoJGzHZbjfsmKyRgeBaJGkkKMuFGkLIcT',
                'is_registered'    => 1,
                'is_admin'    => 1,
                'created_at' => date('Y-m-d H:i:s', $timestamp),
                'updated_at' => date('Y-m-d H:i:s', $timestamp),
                'is_deleted' => 0
            ]
        ];

        $this->insert('users', $admins);

        for ($i = 0; $i < 10 ; ++$i ) {
            $timestamp = $faker->unixTime('now');

            $users[] = [
                'name'    => $faker->name,
                'email'    => $faker->email,
                'password'    => $faker->sha256,
                'token'    => '',
                'is_registered'    => rand(0, 1),
                'is_admin'    => 0,
                'created_at' => date('Y-m-d H:i:s', $timestamp),
                'updated_at' => date('Y-m-d H:i:s', $timestamp),
                'is_deleted' => rand(0, 1)
            ];
        }

        $this->insert('users', $users);
    }
}
