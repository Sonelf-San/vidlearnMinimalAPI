<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
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

        $student = User::create([
            'name'     => 'Student',
            'email'    => 'student@vidlearn.ca',
            'type' => 'student',
            'password' => Hash::make('password'),
            'super_admin' => false,
        ]);
    }
}
