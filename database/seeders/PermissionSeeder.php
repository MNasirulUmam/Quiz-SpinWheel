<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;



class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'question-list',
            'question-create',
            'question-edit',
            'question-delete',
            'players-list',
            'players-create',
            'players-edit',
            'players-delete',
            'game_session-list',
            'game_session-create',
            'game_session-edit',
            'game_session-delete',
         ];
      
         foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
         }
    }
}
