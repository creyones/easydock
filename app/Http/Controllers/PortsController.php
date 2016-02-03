<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PortRequest;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Province;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;

class PortsController extends Controller {

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

			//Query App ports
			$query = new ParseQuery('Puertos');
			$query->select(['name', 'province']);
			$query->ascending('createdAt');
			$query->limit(1000);

			$ports = $query->find();

			return view('ports.index', compact('ports'));
		}
		else
		{
			return view('ports.index');
		}
	}

	public function show($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Port
			$query = new ParseQuery('Puertos');
			$query->equalTo("objectId", $id);

			$ports = $query->find();

			//No results
			if (count($ports) <= 0)
			{
				return view('ports.show')->withErrors(trans('messages.ports.not-found'));
			}

			$port = $ports[0];

			//Query related Docks
			$relQuery = new ParseQuery('Atraques');
			$relQuery->matchesQuery('puertoRelation', $query);

			$docks = $relQuery->find();

			return view('ports.show', compact('port', 'docks'));
		}
		else
		{
			return view('ports.show');
		}
	}

	public function create()
	{
		$provinces = $this->listProvinces();

		return view('ports.create', compact('provinces'));
	}

	public function store(PortRequest $request)
	{

		//Create Parse Port
		$port = new ParseObject('Puertos');
		$port->set('name', $request->get('name'));
		$port->set('province', $request->get('provinces'));
		$port->set('latitude', floatval($request->get('latitude')));
		$port->set('longitude', floatval($request->get('longitude')));

		try {
			$port->save();
			return redirect('ports')->with([
				'flash_message' => trans('messages.ports.created'),
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

			//Query Port
			$query = new ParseQuery('Puertos');
			//Get Port by id
			$port = $query->get($id);

			$provinces = $this->listProvinces();

			return view('ports.edit', compact('port', 'provinces'));
		}
		else
		{
			return view('ports.edit');
		}
	}

	public function update($id, PortRequest $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Port
			$query = new ParseQuery('Puertos');
			//Get Port by id
			$port = $query->get($id);
			$port->set('name', $request->get('name'));
			$port->set('province', $request->get('provinces'));
			$port->set('latitude', floatval($request->get('latitude')));
			$port->set('longitude', floatval($request->get('longitude')));

			try {
				//Update Port in Parse
				$port->save();

				return redirect('ports')->with([
					'flash_message' => trans('messages.ports.updated'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('messages.ports.not-found'));
				}
				else {
					return redirect()->back()->withErrors(trans('validation.custom.parse.save') . $ex->getMessage());
				}
			}
		}
		else
		{
			return redirect('ports');
		}

	}

	public function destroy($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Port
			$query = new ParseQuery('Puertos');
			//Get Port by id
			$port = $query->get($id);

			try {
				//Destroy Port in Parse
				$port->destroy();

				return redirect('ports')->with([
					'flash_message' => trans('messages.ports.deleted'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {

				return redirect()->back()->withErrors(trans('validation.custom.parse') . $ex->getMessage());
			}
		}
		else
		{
			return redirect('ports');
		}
	}

	private function listProvinces()
	{
		//return Provinces::lists('name','name');
		$query = new ParseQuery('Provincias');
		$query->select('nombre');
		$query->ascending("nombre");
		$query->limit(25);
		$items = $query->find();
		$count = $query->count();

		$provinces = [];
		for ($i = 0; $i < $count;++$i)
		{
			$provinces[$items[$i]->get('nombre')] = $items[$i]->get('nombre');
		}
		return $provinces;
	}

}
