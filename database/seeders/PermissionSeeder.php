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
            'division-list',
            'division-create',
            'division-edit',
            'division-delete',
            'complaint_type-list',
            'complaint_type-create',
            'complaint_type-edit',
            'complaint_type-delete',
            'complaint-list',
            'complaint-create',
            'complaint-edit',
            'complaint-delete',
            
         ];
      
         foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
         }
    }
}
