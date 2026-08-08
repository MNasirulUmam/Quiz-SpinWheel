<?php

use Spatie\Permission\Models\Role;

$role = Role::findByName('admin');
$role->givePermissionTo(['session-list', 'session-delete']);
echo "Permissions assigned to admin role.\n";
