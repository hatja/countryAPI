<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $admin = new User;
    $admin->name = 'admin';
    $admin->email = 'admin@admin.hu';
    $admin->password = \Hash::make('1234');
    $admin->save();
    // $this->call(UsersTableSeeder::class);
  }
}
