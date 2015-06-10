<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('PermissionTableSeeder');
		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('ProvinceTableSeeder');

	}

}

class PermissionTableSeeder extends Seeder {

	public function run()
	{

		DB::table('permissions')->delete();

		/*Create user roles*/
		$createUser = new Permission();
		$createUser->name = 'create-user';
		$createUser->display_name = 'Create Users'; // optional
		// Allow a user to...
		$createUser->description = 'create new users'; // optional
		$createUser->save();

		$editUser = new Permission();
		$editUser->name = 'edit-user';
		$editUser->display_name = 'Edit Users'; // optional
		// Allow a user to...
		$editUser->description = 'edit existing users'; // optional
		$editUser->save();

		$deleteUser = new Permission();
		$deleteUser->name = 'delete-user';
		$deleteUser->display_name = 'Delete Users'; // optional
		// Allow a user to...
		$deleteUser->description = 'delete existing users'; // optional
		$deleteUser->save();

		/*Create provider roles*/
		$createProvider = new Permission();
		$createProvider->name = 'create-provider';
		$createProvider->display_name = 'Create Providers'; // optional
		// Allow a provider to...
		$createProvider->description = 'create new providers'; // optional
		$createProvider->save();

		$editProvider = new Permission();
		$editProvider->name = 'edit-provider';
		$editProvider->display_name = 'Edit Providers'; // optional
		// Allow a provider to...
		$editProvider->description = 'edit existing providers'; // optional
		$editProvider->save();

		$deleteProvider = new Permission();
		$deleteProvider->name = 'delete-provider';
		$deleteProvider->display_name = 'Delete Providers'; // optional
		// Allow a provider to...
		$deleteProvider->description = 'delete existing providers'; // optional
		$deleteProvider->save();

		/*Create port roles*/
		$createPort = new Permission();
		$createPort->name = 'create-port';
		$createPort->display_name = 'Create Ports'; // optional
		// Allow a port to...
		$createPort->description = 'create new ports'; // optional
		$createPort->save();

		$editPort = new Permission();
		$editPort->name = 'edit-port';
		$editPort->display_name = 'Edit Ports'; // optional
		// Allow a port to...
		$editPort->description = 'edit existing ports'; // optional
		$editPort->save();

		$deletePort = new Permission();
		$deletePort->name = 'delete-port';
		$deletePort->display_name = 'Delete Ports'; // optional
		// Allow a port to...
		$deletePort->description = 'delete existing ports'; // optional
		$deletePort->save();

		/*Create dock roles*/
		$createDock = new Permission();
		$createDock->name = 'create-dock';
		$createDock->display_name = 'Create Docks'; // optional
		// Allow a dock to...
		$createDock->description = 'create new docks'; // optional
		$createDock->save();

		$editDock = new Permission();
		$editDock->name = 'edit-dock';
		$editDock->display_name = 'Edit Docks'; // optional
		// Allow a dock to...
		$editDock->description = 'edit existing docks'; // optional
		$editDock->save();

		$deleteDock = new Permission();
		$deleteDock->name = 'delete-dock';
		$deleteDock->display_name = 'Delete Docks'; // optional
		// Allow a dock to...
		$deleteDock->description = 'delete existing docks'; // optional
		$deleteDock->save();

		/*Create request roles*/
		$createRequest = new Permission();
		$createRequest->name = 'create-request';
		$createRequest->display_name = 'Create Requests'; // optional
		// Allow a request to...
		$createRequest->description = 'create new requests'; // optional
		$createRequest->save();

		$editRequest = new Permission();
		$editRequest->name = 'edit-request';
		$editRequest->display_name = 'Edit Requests'; // optional
		// Allow a request to...
		$editRequest->description = 'edit existing requests'; // optional
		$editRequest->save();

		$deleteRequest = new Permission();
		$deleteRequest->name = 'delete-request';
		$deleteRequest->display_name = 'Delete Requests'; // optional
		// Allow a request to...
		$deleteRequest->description = 'delete existing requests'; // optional
		$deleteRequest->save();

	}

}

class RoleTableSeeder extends Seeder {

	public function run()
	{

		DB::table('roles')->delete();

		/*Create user roles*/
		$owner = new Role();
		$owner->name = 'owner';
		$owner->display_name = 'Project Owner'; // optional
		$owner->description  = 'User is the owner of a given project'; // optional
		$owner->save();

		$admin = new Role();
		$admin->name = 'admin';
		$admin->display_name = 'User Administrator'; // optional
		$admin->description = 'User is allowed to manage and edit other users'; // optional
		$admin->save();

		$provider = new Role();
		$provider->name = 'provider';
		$provider->display_name = 'Provider'; // optional
		$provider->description = 'User is allowed to manage and edit its own offers'; // optional
		$provider->save();

		/*Query all permissions*/
		$createUser = Permission::where('name', '=', 'create-user')->first();
		$editUser = Permission::where('name', '=', 'edit-user')->first();
		$deleteUser = Permission::where('name', '=', 'delete-user')->first();
		$createProvider = Permission::where('name', '=', 'create-provider')->first();
		$editProvider = Permission::where('name', '=', 'edit-provider')->first();
		$deleteProvider = Permission::where('name', '=', 'delete-provider')->first();
		$createPort = Permission::where('name', '=', 'create-port')->first();
		$editPort = Permission::where('name', '=', 'edit-port')->first();
		$deletePort = Permission::where('name', '=', 'delete-port')->first();
		$createDock = Permission::where('name', '=', 'create-dock')->first();
		$editDock = Permission::where('name', '=', 'edit-dock')->first();
		$deleteDock = Permission::where('name', '=', 'delete-dock')->first();
		$createRequest = Permission::where('name', '=', 'create-request')->first();
		$editRequest = Permission::where('name', '=', 'edit-request')->first();
		$deleteRequest = Permission::where('name', '=', 'delete-request')->first();

		/*Assign permission to roles*/
		$owner->attachPermissions(array($createUser, $editUser, $deleteUser, $createProvider, $editProvider, $deleteProvider, $createPort, $editPort, $deletePort, $createDock, $editDock, $deleteDock, $createRequest, $editRequest, $deleteRequest));
		$admin->attachPermissions(array($createUser, $editUser, $deleteUser, $createProvider, $editProvider, $deleteProvider, $createPort, $editPort, $deletePort, $createDock, $editDock, $deleteDock, $createRequest, $editRequest, $deleteRequest));
		$provider->attachPermissions(array($editPort, $createDock, $editDock, $deleteDock, $createRequest, $editRequest, $deleteRequest));

	}

}

class UserTableSeeder extends Seeder {

	public function run()
	{

		DB::table('users')->delete();

		/*Create owner user*/

		User::create(['username' => env('DB_OWNER', 'user'),
		'email' => env('DB_OWNER_EMAIL', 'admin@example.com'),
		'password' => bcrypt(env('DB_OWNER_PASSWORD', 'secret')),
		'firstname' => 'User',
		'lastname' => 'Owner',
		'city' => 'none',
		'address' => 'Calle X, s/n.',
		'postalcode' => '28000',
		'mobile' => '666 666 666',
		'phone' => '911 111 111']);

		/*Create admin user*/
		User::create(['username' => env('DB_ADMIN', 'user'),
		'email' => env('DB_ADMIN_EMAIL', 'admin@example.com'),
		'password' => bcrypt(env('DB_ADMIN_PASSWORD', 'secret')),
		'firstname' => 'User',
		'lastname' => 'Administrator',
		'city' => 'none','address' => 'Calle X, s/n.',
		'address' => 'Calle X, s/n.',
		'postalcode' => '28001',
		'mobile' => '678 678 678',
		'phone' => '915 123 456']);

		/*Create provider user */
		User::create(['username' => 'puertocolon',
		'email' => 'temp@puertocolon.com',
		'password' => bcrypt('puertocolon38660'),
		'firstname' => 'Administrador',
		'lastname' => 'Puerto Colón',
		'city' => 'Las Américas',
		'address' => 'Calle X, s/n.',
		'postalcode' => '38660',
		'mobile' => '678 123 456',
		'phone' => '922 123 456']);

		/*Assign default user roles*/

		$user = User::where('username', '=', env('DB_OWNER', 'user'))->first();
		$user_admin = User::where('username', '=', env('DB_ADMIN', 'user'))->first();
		$user_pc = User::where('username', '=', 'puertocolon')->first();
		$user_pn = User::where('username', '=', 'palmanova')->first();
		$user_cb = User::where('username', '=', 'calabosch')->first();
		$owner = Role::where('name', '=', 'owner')->first();
		$admin = Role::where('name', '=', 'admin')->first();
		$provider = Role::where('name', '=', 'provider')->first();

		$user->attachRole($owner);
		$user_admin->attachRole($admin);
		$user_pc->attachRole($provider);
		$user_pn->attachRole($provider);
		$user_cb->attachRole($provider);

	}

}

class ProvinceTableSeeder extends Seeder {

	public function run()
	{
		DB::table('provinces')->delete();

		Province::create(['name' => 'Alicante']);
		Province::create(['name' => 'Almería']);
		Province::create(['name' => 'Asturias']);
		Province::create(['name' => 'Baleares']);
		Province::create(['name' => 'Barcelona']);
		Province::create(['name' => 'Cádiz']);
		Province::create(['name' => 'Cantabria']);
		Province::create(['name' => 'Castellón']);
		Province::create(['name' => 'Gerona']);
		Province::create(['name' => 'Guipúzcoa']);
		Province::create(['name' => 'Huelva']);
		Province::create(['name' => 'La Coruña']);
		Province::create(['name' => 'Las Palmas de Gran Canaria']);
		Province::create(['name' => 'Lugo']);
		Province::create(['name' => 'Málaga']);
		Province::create(['name' => 'Murcia']);
		Province::create(['name' => 'Pontevedra']);
		Province::create(['name' => 'Santa Cruz de Tenerife']);
		Province::create(['name' => 'Sevilla']);
		Province::create(['name' => 'Tarragona']);
		Province::create(['name' => 'Valencia']);
		Province::create(['name' => 'Vizcaya']);

	}
}
