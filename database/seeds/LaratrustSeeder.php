<?php
use App\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        $Adminrole = \App\Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin'
        ]);

        $Managerrole = \App\Role::create([
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'Manager'
        ]);

        $Userrole = \App\Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'User'
        ]);


        $user = \App\User::create([
            'name' => 'admin',
            'email' => 'admin@ab.com',
            'password' => bcrypt('password')
        ]);

        $user->attachRole($Adminrole);


        $userManager = \App\User::create([
            'name' => 'admin',
            'email' => 'manager@ab.com',
            'password' => bcrypt('password')
        ]);
        $userManager->attachRole($Managerrole);

        $userNormal = \App\User::create([
            'name' => 'admin',
            'email' => 'user@ab.com',
            'password' => bcrypt('password')
        ]);
        $userNormal->attachRole($Userrole);

    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        \App\User::truncate();
        \App\Role::truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
