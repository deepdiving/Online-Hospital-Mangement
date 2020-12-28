<?php

use Illuminate\Database\Seeder;
// use Sentinel;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
                'name'          => 'Admin',
                'first_name'    => 'Admin',
                'last_name'     => 'AndIt',
                'email'         => 'admin@andit.com',
                'password'      => '123456', //123456
                'created_at'    => now(),
                'updated_at'    => now()
        ];
        $user = \Sentinel::registerAndActivate($users);
        $role = \Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user->id);
        $users = [
                'name'          => 'Pharmacy',
                'first_name'    => 'Pharma Manager',
                'last_name'     => 'AndIt',
                'email'         => 'pharma@andit.com',
                'password'      => '123456', //123456
                'created_at'    => now(),
                'updated_at'    => now()
        ];
        $user = \Sentinel::registerAndActivate($users);
        $role = \Sentinel::findRoleBySlug('pharmacy');
        $role->users()->attach($user->id);

        $users = [
                'name'          => 'Laboratory',
                'first_name'    => 'Lab Manager',
                'last_name'     => 'AndIt',
                'email'         => 'lab@andit.com',
                'password'      => '123456', //123456
                'created_at'    => now(),
                'updated_at'    => now()
        ];
        $user = \Sentinel::registerAndActivate($users);
        $role = \Sentinel::findRoleBySlug('laboratory');
        $role->users()->attach($user->id);

        // $users = [
        //         'name'          => 'Diagnostic',
        //         'first_name'    => 'Diagnostic Manager',
        //         'last_name'     => 'AndIt',
        //         'email'         => 'diagnostic@andit.com',
        //         'password'      => '123456', //123456
        //         'created_at'    => now(),
        //         'updated_at'    => now()
        // ];
        // $user = \Sentinel::registerAndActivate($users);
        // $role = \Sentinel::findRoleBySlug('diagnostic');
        // $role->users()->attach($user->id);

        // $users = [
        //         'name'          => 'Hospital',
        //         'first_name'    => 'Hospital Manager',
        //         'last_name'     => 'AndIt',
        //         'email'         => 'hospital@andit.com',
        //         'password'      => '123456', //123456
        //         'created_at'    => now(),
        //         'updated_at'    => now()
        // ];
        // $user = \Sentinel::registerAndActivate($users);
        // $role = \Sentinel::findRoleBySlug('hospital');
        // $role->users()->attach($user->id);
        
        $users = [
                'name'          => 'Gopal Singh Dhanik',
                'first_name'    => 'Gopal',
                'last_name'     => 'Singh Dhanik',
                'email'         => 'drgopal@andit.com',
                'password'      => '123456', //123456
                'created_at'    => now(),
                'updated_at'    => now()
        ];
        $user = \Sentinel::registerAndActivate($users);
        $role = \Sentinel::findRoleBySlug('doctor');
        $role->users()->attach($user->id);

        // $users = [
        //         'name'          => 'Vivek Saxena',
        //         'first_name'    => 'Vivek',
        //         'last_name'     => 'Saxena',
        //         'email'         => 'saxena@andit.com',
        //         'password'      => '123456', //123456
        //         'created_at'    => now(),
        //         'updated_at'    => now()
        // ];
        // $user = \Sentinel::registerAndActivate($users);
        // $role = \Sentinel::findRoleBySlug('doctor');
        // $role->users()->attach($user->id);

        // $users = [
        //         'name'          => 'Dr. Alok Bajpai',
        //         'first_name'    => 'Alok',
        //         'last_name'     => 'Bajpai',
        //         'email'         => 'alok@andit.com',
        //         'password'      => '123456', //123456
        //         'created_at'    => now(),
        //         'updated_at'    => now()
        // ];
        // $user = \Sentinel::registerAndActivate($users);
        // $role = \Sentinel::findRoleBySlug('doctor');
        // $role->users()->attach($user->id);

        $users = [
                'name'          => 'Manager',
                'first_name'    => 'Manager',
                'last_name'     => 'AndIt',
                'email'         => 'manager@andit.com',
                'password'      => '123456', //123456
                'created_at'    => now(),
                'updated_at'    => now()
        ];
        $user = \Sentinel::registerAndActivate($users);
        $role = \Sentinel::findRoleBySlug('manager');
        $role->users()->attach($user->id);

        $users = [
                'name'          => 'Tapas',
                'first_name'    => 'Tapas',
                'last_name'     => 'Pal',
                'email'         => 'receptionist@andit.com',
                'password'      => '123456', //123456
                'created_at'    => now(),
                'updated_at'    => now()
        ];
        $user = \Sentinel::registerAndActivate($users);
        $role = \Sentinel::findRoleBySlug('receptionist');
        $role->users()->attach($user->id);
    }
}
