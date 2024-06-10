<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        if (User::count() > 0) {
//            return;
//        }

        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@vidlearn.ca',
            'type' => 'admin',
            'password' => Hash::make('password'),
            'super_admin' => true,
        ]);
    }
}
