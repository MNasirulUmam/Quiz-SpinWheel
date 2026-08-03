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
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'pic-list',
            'pic-create',
            'pic-edit',
            'pic-delete',
            'units-list',
            'units-create',
            'units-edit',
            'units-delete',
            
         ];
      
         foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
         }
    }
}
