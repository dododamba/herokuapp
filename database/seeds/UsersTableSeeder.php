<?php

use Illuminate\Database\Seeder;

class UsersGenerate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		  DB::table('users')->insert([
			[		
					'email' 		=> 'admin@admin.com',
					'password' 		=> bcrypt('password'),
					'permissions' 	=> '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"user.index":true,"user.create":true,"user.store":true,"user.show":true,"user.edit":true,"user.update":true,"user.destroy":true,"user.permissions":true,"user.save":true,"user.activate":true,"user.deactivate":true,"role.index":true,"role.create":true,"role.store":true,"role.show":true,"role.edit":true,"role.update":true,"role.destroy":true,"role.permissions":true,"role.save":true}',
					'role' => 1,
					'langue' => 'en',
					'telephone' => '0000000',
					'slug' => str_randomize(10)
			]

		]);
           
        
		DB::table('roles')->insert([
			[		
					'slug' 		=> 'admin',
					'name' 			=> 'Admin',
					'permissions' 	=> '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"user.index":true,"user.create":true,"user.store":true,"user.show":true,"user.edit":true,"user.update":true,"user.destroy":true,"user.permissions":true,"user.save":true,"user.activate":true,"user.deactivate":true,"role.index":true,"role.create":true,"role.store":true,"role.show":true,"role.edit":true,"role.update":true,"role.destroy":true,"role.permissions":true,"role.save":true,"pages.getroles":true}',
			]
	 ]);
	 DB::table('role_users')->insert([
			[		
					'user_id' 		=> '1',
					'role_id' 			=> '1',
			]
	 ]);
	 DB::table('activations')->insert([
			[		
					'user_id' 		=> '1',
					'code' 			=> '1S4u7lJzehk62xDm3DgYgXXYWtbHE6gSP',
					'completed' 			=> '1',
			]
	 ]);
		
		 
    }
}
