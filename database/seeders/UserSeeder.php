<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
            'name' => 'admin',
            'email' => 'admin@bhc.com',
            'password' => '12345678'
            ],
            [
            'name' => 'management',
            'email' => 'management@bhc.com',
            'password' => '12345678'
            ],
            [
            'name' => 'staff',
            'email' => 'staff@bhc.com',
            'password' => '12345678'
           ]
        ];

        foreach ($users as $user) {
            $data = User::firstOrCreate([
                'name'      => $user['name'], 
                'email'     => $user['email'],
                'password'  => bcrypt($user['password'])
            ]);

            $role = Role::where('name', $user['name'])->first();

            $data->assignRole($role->name);
        }
    }
}
