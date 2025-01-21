<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Insert multiple admins
        $admins = [
            [
                'image' => '/test',
                'name' => 'Super Test',
                'email' => 'user@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'status' => 1,
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => '/test',
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'status' => 1,
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => '/test',
                'name' => 'Writer User',
                'email' => 'writer@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'status' => 1,
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        // Insert the records into the database
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
