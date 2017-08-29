<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Defender::createRole('slc');
        Defender::createRole('admin');
        Defender::createRole('user');
    }
}
