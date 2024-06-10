<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        if (User::count() > 0) {
//            return;
//        }

        $lecturer = User::create([
            'name'     => 'Lecturer',
            'email'    => 'lecturer@vidlearn.ca',
            'type' => 'lecturer',
            'password' => Hash::make('password'),
            'super_admin' => false,
        ]);
    }
}
