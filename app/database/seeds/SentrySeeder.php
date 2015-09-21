<?php

/**
 * SentrySeeder
 * 
 * Fill up the sentry (auth) tables
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class SentrySeeder extends Illuminate\Database\Seeder {

  public function run()
  {
    DB::table('users')->delete();
    DB::table('groups')->delete();
    DB::table('users_groups')->delete();

    Sentry::getUserProvider()->create(array(
        'email' => Config::get('cottaging.admin-email'),
        'password' => "admin",
        'first_name' => 'The',
        'last_name' => 'Management',
        'activated' => 1,
    ));

    Sentry::getGroupProvider()->create(array(
        'name' => 'Admin',
        'permissions' => array('admin' => 1),
    ));

    // Assign user permissions
    $adminUser = Sentry::getUserProvider()->findByLogin(Config::get('cottaging.admin-email'));
    $adminGroup = Sentry::getGroupProvider()->findByName('Admin');
    $adminUser->addGroup($adminGroup);
    
    Sentry::getUserProvider()->create(array(
        'email' => 'testuser@gmail.com',
        'password' => "testuser",
        'first_name' => 'Test',
        'last_name' => 'User',
        'activated' => 1,
    ));    
  }
}

