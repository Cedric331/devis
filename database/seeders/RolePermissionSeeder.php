<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'clients.create',
            'clients.read',
            'clients.update',
            'clients.delete',
            'quotes.create',
            'quotes.read',
            'quotes.update',
            'quotes.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $owner = Role::firstOrCreate(['name' => 'owner']);
        $owner->givePermissionTo($permissions);

        $member = Role::firstOrCreate(['name' => 'member']);
        $member->givePermissionTo([
            'clients.create',
            'clients.read',
            'clients.update',
            'quotes.create',
            'quotes.read',
            'quotes.update',
        ]);
    }
}
