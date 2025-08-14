<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $company = Company::factory()->create([
            'name' => 'Demo Company',
        ]);

        $owner = User::factory()->create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'company_id' => $company->id,
        ]);
        $owner->assignRole('owner');

        $member = User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'company_id' => $company->id,
        ]);
        $member->assignRole('member');
    }
}
