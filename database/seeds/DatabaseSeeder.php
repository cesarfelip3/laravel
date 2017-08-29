<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (app()->environment('production')) {
            exit('I just stopped you getting fired. Love Jeremias! S2');
        }

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
