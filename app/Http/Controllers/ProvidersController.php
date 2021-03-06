<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ProviderRequest;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;

class ProvidersController extends Controller {

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('manager', ['except'=>'index']);

	}

	public function index()
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query App providers
			$query = new ParseQuery('Vendedores');
			$query->select(['username', 'email']);
			$query->ascending('createdAt');
			$query->limit(1000);

			$providers = $query->find();

			return view('providers.index', compact('providers'));
		}
		else
		{
			return view('providers.index');
		}
	}

	public function show($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Provider
			$query = new ParseQuery('Vendedores');
			$query->equalTo("objectId", $id);

			$providers = $query->find();

			//No results
			if (count($providers) <= 0)
			{
				return view('providers.show')->withErrors(trans('messages.providers.not-found'));
			}

			$provider = $providers[0];

			//Query related Docks
			$relQuery = new ParseQuery('Atraques');
			$relQuery->matchesQuery('vendedorRelation', $query);

			$docks = $relQuery->find();

			//Query Laravel Profile
			$profile = User::where('username', '=', $provider->get('username'))->first();

			//Query port
			$rel = $provider->get('puertoRelation')->getQuery()->find();
			$port = null;
			if(!empty($rel)){
				$port = $provider->get('puertoRelation')->getQuery()->find()[0];
			}

			return view('providers.show', compact('provider', 'docks', 'profile', 'port'));
		}
		else
		{
			return view('providers.show');
		}
	}

	public function create()
	{
		$ports = $this->listPorts();
		return view('providers.create', compact('ports'));
	}

	public function store(ProviderRequest $request)
	{

		//Create Parse Provider
		$provider = new ParseObject('Vendedores');
		$provider->set('username', $request->get('username'));
		$provider->set('email', $request->get('email'));
		$provider->set('password', $request->get('password'));
		//Set Port Relation
		$this->setPort($provider, $request->get('port'));

		//Create Laravel Profile
		$profile = new User;

		$profile->firstname = $request->get('firstname');
		$profile->lastname 	= $request->get('lastname');
		$profile->username	= $request->get('username');
		$profile->port			= $request->get('port');
		$profile->email     = $request->get('email');
		$profile->address  	= $request->get('address');
		$profile->city   		= $request->get('city');
		$profile->postalcode = $request->get('postalcode');
		$profile->mobile	  = $request->get('mobile');
		$profile->phone	  	= $request->get('phone');
		$profile->password  = bcrypt($request->get('password'));

		$role = Role::where('name', '=', 'provider')->first();
		$profile->save();

		$profile->attachRole($role);
		$profile->save();

		try {
			$provider->save();
			return redirect('providers')->with([
				'flash_message' => trans('messages.providers.created'),
				'flash_message_important' => true
				]);
			// Hooray! Let them use the app now.
		} catch (ParseException $ex) {

		}
	}

	public function edit($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Provider
			$query = new ParseQuery('Vendedores');
			//Get Provider by id
			$provider = $query->get($id);
			$roles = Role::lists('display_name','name');

			//Query Laravel Profile
			$profile = User::where('username', '=', $provider->get('username'))->first();

			//List ports
			$ports = $this->listPorts();
			$rel = $provider->get('puertoRelation')->getQuery()->find();
			$port = null;
			if(!empty($rel)){
				$port = $provider->get('puertoRelation')->getQuery()->find()[0];
			}

			return view('providers.edit', compact('provider', 'profile', 'roles', 'ports', 'port'));
		}
		else
		{
			return view('providers.edit');
		}
	}

	public function update($id, ProviderRequest $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Provider
			$query = new ParseQuery('Vendedores');
			//Get Provider by id
			$provider = $query->get($id);
			$provider->set('email', $request->get('email'));
			$provider->set('username', $request->get('username'));
			$provider->set('password', bcrypt($request->get('password')));
			//Set Port Relation
			$this->setPort($provider, $request->get('port'));

			//Update Laravel Profile
			$profile = User::where('username', '=', $provider->get('username'))->first();
			$profile->update($request->all());

			//Update roles
			if(!$profile->hasRole($request->get('role'))) {
				$role = Role::where('name', '=', $request->get('role'))->first();
				$profile->attachRole($role);
			}

			try {
				//Update Provider in Parse
				$provider->save();

				return redirect('providers')->with([
					'flash_message' => trans('messages.providers.updated'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('messages.providers.not-found'));
				}
				else {
					return redirect()->back()->withErrors(trans('parse.save') . $ex->getMessage());
				}
			}
		}
		else
		{
			return redirect('providers');
		}

	}

	public function destroy($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Provider
			$query = new ParseQuery('Vendedores');
			//Get Provider by id
			$provider = $query->get($id);

			//Delete Laravel Profile
			$profile = User::where('username', '=', $provider->get('username'))->first();
			if($profile)
			{
				$profile->delete();
			}

			try {
				//Delete related docks
				$q = new ParseQuery('Atraques');
				$q->equalTo('vendedorRelation', $provider);
				$docks = $q->find();
				foreach ($docks as $dock)
				{
					$dock->destroy();
				}

				//Destroy Provider in Parse
				$provider->destroy();

				return redirect('providers')->with([
					'flash_message' => trans('messages.provider_deleted'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {

				return redirect()->back()->withErrors(trans('parse.delete') . $ex->getMessage());
			}
		}
		else
		{
			return redirect('providers');
		}
	}

	private function setPort($provider, $name) {
		$query = new ParseQuery('Puertos');
		$query->equalTo("name", $name);
		$port = $query->find()[0];
		$provider->getRelation("puertoRelation")->add($port);
	}

	private function listPorts()
	{
		$query = new ParseQuery('Puertos');
		$query->select('name');
		$query->ascending("name");
		$query->limit(500);
		$items = $query->find();
		$count = $query->count();

		$ports = [];
		for ($i = 0; $i < $count; ++$i)
		{
			$ports[$items[$i]->get('name')] = $items[$i]->get('name');
		}
		return $ports;
	}

}
