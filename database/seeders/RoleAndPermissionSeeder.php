<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Role::create(['name' => \App\Enums\Role::ADMIN->value]);
		Role::create(['name' => \App\Enums\Role::SKPD->value]);
	}
}
