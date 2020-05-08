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
        $data = [
            [
                'name'    => 'Benjamin',
                'email'    => 'benjaminhaise@gmail.com',
                'password'    => '$2y$10$dbBRgGS4QlBlzqtkesZZluKFoJ932W5FvaTIR5kDN8HmGw16LsR0e',
                'is_admin'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'is_deleted' => 0
            ]
        ];

        $this->insert('users', $data);
    }
}
