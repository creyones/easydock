<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\DockRequest;
use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use Intervention\Image\Facades\Image;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseFile;
use Parse\ParseRelation;
use Parse\ParseException;

Use Carbon\Carbon;

class DocksController extends Controller {

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Docks
			$query = new ParseQuery('Atraques');
			$query->select(['name', 'puertoRelation', 'vendedorRelation']);
			$query->ascending('createdAt');

			$docks = $query->find();

			return view('docks.index', compact('docks'));
		}
		else if($current_user->hasRole('provider')){
			//Query provider
			$rel = new ParseQuery('Vendedores');
			$rel->equalTo('username', $current_user->username);
			$provider = $this->getCurrentProvider();

			//Query Docks
			$query = new ParseQuery('Atraques');
			$query->equalTo('vendedorRelation', $provider);
			$query->select(['name', 'puertoRelation', 'vendedorRelation']);
			$query->ascending('createdAt');

			$docks = $query->find();

			return view('docks.index', compact('docks'));
		}
		else
		{
			return view('docks.index');
		}
	}

	public function show($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner') || $current_user->hasRole('provider')){

			//Query Dock
			$query = new ParseQuery('Atraques');
			$query->equalTo("objectId", $id);

			if($current_user->hasRole('provider')) {
				$query->equalTo("vendedorRelation", $this->getCurrentProvider());
			}
			$docks = $query->find();

			//No results
			if (count($docks) <= 0)
			{
				return view('docks.show')->withErrors(trans('validation.custom.not-found'));
			}

			$dock = $docks[0];

			$port = $dock->get('puertoRelation')->getQuery()->find()[0];
			$provider = $dock->get('vendedorRelation')->getQuery()->find()[0];

			//Query related Bookings
			$q = new ParseQuery('Solicitudes');
			$q->matchesQuery('atraqueRelation', $query);
			$q->ascending('fechaInicio');

			$bookings = $q->find();

			//Query related Products
			$q = new ParseQuery('Productos');
			$q->matchesQuery('atraqueRelation', $query);
			$q->ascending('fecha');

			$products = $q->find();

			return view('docks.show', compact('dock', 'port', 'provider', 'bookings', 'products'));
		}
		else
		{
			return view('docks.show');
		}
	}

	public function create()
	{
		$current_user = Auth::user();

		if( $current_user->hasRole('provider') ) {
			$provider = $this->getCurrentProvider();
			$port = $provider->get('puertoRelation')->getQuery()->find()[0];
			return view('docks.create', compact('port', 'provider'));
		}
		else {
			$ports = $this->listPorts();
			$providers = $this->listProviders();
			return view('docks.create', compact('ports', 'providers'));
		}
	}

	public function store(DockRequest $request)
	{

		$file = $request->file('image');

		if ($file and $file->isValid()){
			//Original Image
			$filepath = public_path('img') . "/" . $file->getClientOriginalName();
			$file->move(public_path('img'), $file->getClientOriginalName());

		}
		else {
			return redirect()->back()->withErrors(trans('validation.custom.not-found'));
		}

		$filepath = public_path('img') . "/" . $file->getClientOriginalName();

		//Fit Images
		$imagepath = $this->fitImage($filepath, 480, 480);
		$thumbpath = $this->fitImage($imagepath, 240, 240, 'thumb');

		//Create Parse Files
		$image = ParseFile::createFromFile($imagepath, basename($imagepath));
		$thumbnail = ParseFile::createFromFile($thumbpath, basename($thumbpath));

		// Carbonize dates
		$begin = createDate($request->get('from'));
		$end = createDate($request->get('until'));

		//Create Parse Dock
		$dock = new ParseObject('Atraques');
		$dock->set('name', $request->get('name'));
		$dock->set('detailText', $request->get('details'));
		$dock->set('codigo', $request->get('code'));
		$dock->set('fechaInicio', $begin);
		$dock->set('fechaFinal', $end);
		$dock->set('precio', floatval($request->get('price')));
		$dock->set('image', $image);
		$dock->set('thumbnail', $thumbnail);
		$dock->set('available', true);
		$dock->set('manga', floatval($request->get('beam')));
		$dock->set('eslora', floatval($request->get('length')));
		$dock->set('calado', floatval($request->get('draft')));
		$dock->set('agua', $request->get('water') == '1' ? true : false);
		$dock->set('electricidad', $request->get('power') == '1' ? true : false);
		$dock->set('gasolinera', $request->get('gas') == '1' ? true : false);
		$dock->set('marineros', $request->get('naval') == '1' ? true : false);
		$dock->set('radio', $request->get('radio') == '1' ? true : false);
		$dock->set('restaurantes', $request->get('restaurant') == '1' ? true : false);
		$dock->set('taquillas', $request->get('locker') == '1' ? true : false);
		$dock->set('vestuarios', $request->get('lockerroom') == '1' ? true : false);
		$dock->set('hoteles', $request->get('accomodation') == '1' ? true : false);
		$dock->set('vigilancia', $request->get('surveillance') == '1' ? true : false);
		$dock->set('wifi', $request->get('wifi') == '1' ? true : false);

		$dock->set('provincia', $port->get('province'));

		$port = null;
		$provider = null;
		if( $current_user->hasRole('provider') ) {
			$provider = $this->getCurrentProvider();
			$port = $provider->get('puertoRelation')->getQuery()->find()[0];
		}
		else
		{
			//Set Provider Relation
			$query = new ParseQuery('Vendedores');
			$query->equalTo('username', $request->get('providers'));

			$providers = $query->find();
			$provider = $providers[0];

			//Set Port Relation
			$query = new ParseQuery('Puertos');
			$query->equalTo('name', $request->get('ports'));

			$ports = $query->find();
			$port = $ports[0];
		}

		$dock->getRelation('puertoRelation')->add($port);
		$dock->getRelation('vendedorRelation')->add($provider);
		dd($dock);
		try {

			$image->save();
			$thumbnail->save();
			$dock->save();

			//Create related products
			$this->createProducts($dock, $begin, $end, floatval($request->get('price')));

			return redirect('docks')->with([
				'flash_message' => trans('messages.dock_created'),
				'flash_message_important' => true
				]);
			// Hooray! Let them use the app now.
		} catch (ParseException $ex) {

		}
	}

	public function edit($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner') || $current_user->hasRole('provider')){

			//Query Port
			$query = new ParseQuery('Atraques');

			try {
				//Get Port by id
				$dock = $query->get($id);

				$port = $dock->get('puertoRelation')->getQuery()->find()[0];
				$provider = $dock->get('vendedorRelation')->getQuery()->find()[0];

				if ($current_user->hasRole('provider') && $provider->get('username') != $current_user->username) {
					return redirect()->back()->withErrors('No Permissions');
				}

				$ports = $this->listPorts();
				$providers = $this->listProviders();

				return view('docks.edit', compact('dock', 'port', 'provider', 'ports', 'providers'));

			}
			catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('validation.custom.not-found'));
				}
			}
		}
		else
		{
			return view('docks.edit');
		}
	}

	public function update($id, Request $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner') || $current_user->hasRole('provider')){

			$this->validate($request, [
				'code' => 'required|min:6|max:40',
				'name' => 'required|min:8|max:40',
				'details' => 'required|min:20|max:300',
				'from' => 'required',
				'until' => 'required',
				'beam' => 'required',
				'length' => 'required',
				'draft' => 'required',
			]);

			//Query Port
			$query = new ParseQuery('Atraques');
			//Get Port by id
			$dock = $query->get($id);
			$dock->set('name', $request->get('name'));
			$dock->set('detailText', $request->get('details'));
			$dock->set('codigo', $request->get('code'));
			$dock->set('precio', floatval($request->get('price')));
			$dock->set('manga', floatval($request->get('beam')));
			$dock->set('eslora', floatval($request->get('length')));
			$dock->set('calado', floatval($request->get('draft')));
			$dock->set('agua', $request->get('water') == '1' ? true : false);
			$dock->set('electricidad', $request->get('power') == '1' ? true : false);
			$dock->set('gasolinera', $request->get('gas') == '1' ? true : false);
			$dock->set('marineros', $request->get('naval') == '1' ? true : false);
			$dock->set('radio', $request->get('radio') == '1' ? true : false);
			$dock->set('restaurantes', $request->get('restaurant') == '1' ? true : false);
			$dock->set('taquillas', $request->get('locker') == '1' ? true : false);
			$dock->set('vestuarios', $request->get('lockerroom') == '1' ? true : false);
			$dock->set('hoteles', $request->get('accomodation') == '1' ? true : false);
			$dock->set('vigilancia', $request->get('surveillance') == '1' ? true : false);
			$dock->set('wifi', $request->get('wifi') == '1' ? true : false);

			//Check if date has changed

			//Previous date
			$pfrom = createDate($dock->get('fechaInicio')->format('d/m/Y'));
			$puntil = createDate($dock->get('fechaFinal')->format('d/m/Y'));

			//New date
			$from = createDate($request->get('from'));
			$until = createDate($request->get('until'));

			if ( $from->ne($pfrom) or $until->ne($puntil) )
			{
				//Update products
				$price = floatval($request->get('price'));

				if($from->gt($pfrom))
				{
					//Remove if possible
					$this->destroyProducts($dock, $pfrom, $from->subDay());

				}
				else if ($from->lt($pfrom))
				{
					//Add new products
					$this->createProducts($dock, $from, $pfrom->subDay(), $price);
				}

				if($until->gt($puntil))
				{
					//Add new products
					$this->createProducts($dock, $puntil->addDay(), $until, $price);
				}
				else if ($until->lt($puntil))
				{
					//Remove if possible
					$this->destroyProducts($dock, $until->addDay(), $puntil);
				}

				$dock->set('fechaInicio', createDate($request->get('from')));
				$dock->set('fechaFinal', createDate($request->get('until')));

			}

			//Check if image is has changed
			$file = $request->file('image');

			if ($file and $file->isValid()){
				//dd($file);
				//Original Image
				$filepath = public_path('img') . "/" . $file->getClientOriginalName();
				$file->move(public_path('img'), $file->getClientOriginalName());

				//Fit Images
				$imagepath = $this->fitImage($filepath, 480, 480);
				$thumbpath = $this->fitImage($imagepath, 240, 240, 'thumb');

				//Create Parse Files
				$image = ParseFile::createFromFile($imagepath, basename($imagepath));
				$thumbnail = ParseFile::createFromFile($thumbpath, basename($thumbpath));

				//Save Objects
				$image->save();
				$thumbnail->save();

				//Set New Values
				$dock->set('thumbnail', $thumbnail);
				$dock->set('image', $image);
			}

			if(!$current_user->hasRole('provider'))
			{
				//Set Port Relation
				$query = new ParseQuery('Puertos');
				$query->equalTo("name", $request->get('ports'));

				$ports = $query->find();
				$port = $ports[0];
				$dock->getRelation("puertoRelation")->add($port);
				$dock->set('provincia', $port->get('province'));

				//Set Provider Relation
				$query = new ParseQuery('Vendedores');
				$query->equalTo("username", $request->get('providers'));

				$providers = $query->find();
				$provider = $providers[0];
				$dock->getRelation("vendedorRelation")->add($provider);
			}

			try {
				//Update Port in Parse
				$dock->save();

				return redirect('docks')->with([
					'flash_message' => trans('messages.dock_updated'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('validation.custom.not-found'));
				}
				else {
					return redirect()->back()->withErrors(trans('validation.custom.parse') . $ex->getMessage());
				}
			}
		}
		else
		{
			return redirect('docks');
		}

	}

	public function destroy($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Port
			$query = new ParseQuery('Atraques');
			//Get Port by id
			$dock = $query->get($id);

			try {
				//Destroy related Bookings
				$relQuery = new ParseQuery('Solicitudes');
				$relQuery->equalTo('atraqueRelation', $dock);

				$bookings = $relQuery->find();
				for ($i = 0; $i < count($bookings); $i++) {
  				$booking = $bookings[$i];
  				$booking->destroy();
				}

				//Destroy related Products
				$this->destroyProducts($dock);

				//Destroy Port in Parse
				$dock->destroy();

				return redirect('docks')->with([
					'flash_message' => trans('messages.dock_deleted'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {

				return redirect()->back()->withErrors(trans('validation.custom.parse') . $ex->getMessage());
			}
		}
		else
		{
			return redirect('docks');
		}
	}

	private function listPorts()
	{
		//return Provinces::lists('name','name');
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

	private function listProviders()
	{
		//return Provinces::lists('name','name');
		$query = new ParseQuery('Vendedores');
		$query->select('username');
		$query->ascending("username");
		$query->limit(500);
		$items = $query->find();
		$count = $query->count();

		$users = [];
		for ($i = 0; $i < $count; ++$i)
		{
			$users[$items[$i]->get('username')] = $items[$i]->get('username');
		}
		return $users;
	}

	private function getCurrentProvider() {
		//Query provider
		$rel = new ParseQuery('Vendedores');
		$rel->equalTo('username', Auth::user()->username);
		$provider = $rel->find()[0];

		return $provider;
	}

	private function fitImage($path, $width, $height, $suffix = 'scaled')
	{
		//Scaled Image
		$parts = pathinfo($path);

		$name = $parts['filename'];
		$ext = $parts['extension'];
		$dirname = $parts['dirname'];
		$output = $dirname . '/' . $name . '-' . $suffix . '.' . $ext;

		Image::make($path)->fit($width, $height)->save($output);

		return $output;

	}

	private function createProducts($dock, $begin, $end, $price)
	{
		$day = $begin;
		do
		{
			$product = new ParseObject('Productos');
			$product->set('confirmado', false);
			$product->set('reservado', false);
			$product->set('precio', $price);
			$product->set('fecha', $day);
			$product->getRelation('atraqueRelation')->add($dock);

			$product->save();

			//Next
			$day->addDay();

		} while ($day->lte($end));

	}

	private function destroyProducts($dock, $begin = null, $end = null)
	{

		$q = new ParseQuery('Productos');
		$q->equalTo('atraqueRelation', $dock);

		if($begin) {
			$q->greaterThanOrEqualTo('fecha', $begin);
		}
		if ($end) {
			$q->lessThanOrEqualTo('fecha', $end);
		}

		$products = $q->find();

		foreach($products as $product)
		{
			$product->destroy();
		}

	}

}
