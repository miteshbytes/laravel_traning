<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Mitesh Patel',
            'email' => 'mitesh123@yopmail.com',
            'password' => Hash::make('mitesh@123'),
            'gender' => 'male',
            'birth_date' => '2011-05-05',
            'image' => 'profiles/dummy.jpg',
            'role_id' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
