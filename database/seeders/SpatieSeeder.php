<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SpatieSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  private $permissions = [
    'rolesPermissions',
    'users',
    'types',
    'admin-statistics',
    'articles-show',
    'articles-controll',
  ];

  public function run(): void
  {
    foreach ($this->permissions as $permission) {
      Permission::create(['name' => $permission]);
    }

    // Create admin User and assign the role to him.
    $user = User::create([
      'name' => 'Admin',
      'email' => 'admin@gmail.com',
      'type' => 'male',
      'password' => Hash::make("123456"),
      'email_verified_at' => now(),
    ]);

    $role = Role::create(['name' => 'Owner']);

    $permissions = Permission::pluck('id', 'id')->all();

    $role->syncPermissions($permissions);

    $user->assignRole([$role->id]);
  }
}
