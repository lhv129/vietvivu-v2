<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'SuperAdmin',
            'Admin',
            'Customer',
            'Author'
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role],
                [
                    'slug' => Str::slug($role),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
