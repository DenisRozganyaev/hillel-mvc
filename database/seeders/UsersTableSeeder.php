<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'name' => 'Denys',
            'surname' => 'Admin',
            'birthdate' => '1976-03-18',
            'email' => 'admin@heroku.com',
            'phone' => '+34631223963286',
            'password' => \Hash::make('test1234'),
            'role_id' => 1
        ]);

        $user->save();
        User::factory(15)->create();
    }
}
