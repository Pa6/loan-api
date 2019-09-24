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


        $Adminrole = \App\Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin'
        ]);

        $driverRole = \App\Role::create([
            'name' => 'driver',
            'display_name' => 'Driver',
            'description' => 'Driver'
        ]);

        $rentRole = \App\Role::create([
            'name' => 'rent',
            'display_name' => 'Rent',
            'description' => 'Rent'
        ]);

        $clientRole = \App\Role::create(
            [
                'name' => 'client',
                'display_name' => 'Client',
                'description' => 'Client'

            ]
        );



        $user = \App\User::create([
            'first_name' => 'Admin',
            'last_name' => 'Ninja',
            'phone' => '0788355919',
            'email' => 'admin@transport.rw',
            'password' => bcrypt('admin')
        ]);

        $user->attachRole($Adminrole);


        $userDriver = \App\User::create([
            'phone' => '0786160780',
            'first_name' => 'Driver',
            'last_name' => 'Transporter',
            'email' => 'driver@transport.rw',
            'password' => bcrypt('transport')
        ]);
        $userDriver->attachRole($driverRole);

        $userRent = \App\User::create([
            'first_name' => 'Rent',
            'last_name' => 'MrX',
            'phone' => '0788821046',
            'email' => 'rent@transport.rw',
            'password' => bcrypt('rent')
        ]);
        $userRent->attachRole($rentRole);

        $clientUser = \App\User::create([
            'phone' => '0788355902',
            'last_name' => 'Eric',
            'first_name' => 'Ar',
            'email' => 'agent@transport.rw',
            'password' => bcrypt('agent')
        ]);
        $clientUser->attachRole($clientRole);



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
