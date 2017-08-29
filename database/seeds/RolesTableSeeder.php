<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Defender::createRole('slc');
        Defender::createRole('admin');
        Defender::createRole('user');
        Defender::createRole('client');
    }
}
