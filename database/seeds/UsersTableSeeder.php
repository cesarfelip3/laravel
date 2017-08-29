<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $this->createSupportUser();
        if (app()->environment('local')) {
            $this->createAdminUsers();
            $this->createUserUsers();
        }
    }

    public static function createSupportUser()
    {
        $role = Defender::findRole('slc');

        /** @var User $user */
        $user = factory(\App\Models\User::class)->create([
            'name' => 'Support SLC DevShop',
            'email' => 'support@slcdevshop.com',
            'password' => bcrypt('slcdev##')
        ]);
        $user->attachRole($role);
    }

    private function createAdminUsers()
    {
        $role = Defender::findRole('admin');
        factory(\App\Models\User::class, 5)
            ->create()
            ->each(function (User $user) use ($role) {
                $user->attachRole($role);
            });
    }

    private function createUserUsers()
    {
        $role = Defender::findRole('user');

        factory(\App\Models\User::class, 5)
            ->create()
            ->each(function (User $user) use ($role) {
                $user->attachRole($role);
            });
    }
}
