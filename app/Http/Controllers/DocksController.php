<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\DockRequest;
use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
			$provider = $this->getRelatedProvider();

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
				$query->equalTo("vendedorRelation", $this->getRelatedProvider());
			}
			$docks = $query->find();

			//No results
			if (count($docks) <= 0)
			{
				return view('docks.show')->withErrors(trans('messages.docks.not-found'));
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
			$provider = $this->getRelatedProvider();
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
		//Create Parse Dock
		$dock = new ParseObject('Atraques');
		//dd($request);
		$file = $request->file('image');

		if ($file and $file->isValid()){
			//Original Image
			$file->move(public_path('img/docks/'), $file->getClientOriginalName());
			$filepath = public_path('img/docks/') . $file->getClientOriginalName();

			//Fit Images
			$imagepath = $this->fitImage($filepath, 480, 480);
			$thumbpath = $this->fitImage($imagepath, 240, 240, 'thumb');

			//Create Parse Files
			$image = ParseFile::createFromFile($imagepath, basename($imagepath));
			$thumbnail = ParseFile::createFromFile($thumbpath, basename($thumbpath));

			// Carbonize dates
			$start = createDate($request->get('from'));
			$end = createDate($request->get('until'));
			$dock->set('image', $image);

		}
		else {
			return redirect()->back()->withErrors(trans('messages.docks.not-found'));
		}
		$dock->set('name', $request->get('name'));
		$dock->set('detailText', $request->get('details'));
		$dock->set('codigo', $request->get('code'));
		$dock->set('fechaInicio', $start);
		$dock->set('fechaFinal', $end);
		$dock->set('precio', floatval($request->get('price')));
		$dock->set('thumbnail', $thumbnail);
		$dock->set('available', true);
		$dock->set('manga', floatval($request->get('beam')));
		$dock->set('eslora', floatval($request->get('length')));
		$dock->set('calado', floatval($request->get('draft')));

		//Get Provider Relation
		$provider = $this->getRelatedProvider($request->get('provider'));
		//Get Port Relation
		$port = $this->getRelatedPort($request->get('port'));

		$dock->getRelation('puertoRelation')->add($port);
		$dock->getRelation('vendedorRelation')->add($provider);
		$dock->set('provincia', $port->get('province'));
		//Set port services by default
		$dock->set('agua', $port->get('agua'));
		$dock->set('electricidad', $port->get('electricidad'));
		$dock->set('gasolinera', $port->get('gasolinera'));
		$dock->set('marineros', $port->get('marineros'));
		$dock->set('radio', $port->get('radio'));
		$dock->set('restaurantes', $port->get('restaurantes'));
		$dock->set('taquillas', $port->get('taquillas'));
		$dock->set('vestuarios', $port->get('vestuarios'));
		$dock->set('hoteles', $port->get('hoteles'));
		$dock->set('vigilancia', $port->get('vigilancia'));
		$dock->set('wifi', $port->get('wifi'));
		//Offer text
		$dock->set('oferta', $port->get('oferta'));

		try {

			$image->save();
			$thumbnail->save();
			$dock->save();

			//Create related products
			$this->createProducts($dock, $start, $end, floatval($request->get('price')));

			return redirect('docks')->with([
				'flash_message' => trans('messages.docks.created'),
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

			//Query Dock
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

				return view('docks.edit', compact('dock', 'port', 'provider', 'ports', 'providers', 'bookings', 'products'));

			}
			catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('messages.docks.not-found'));
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

			//Query Dock
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
			//Offer text
			$dock->set('oferta', $request->get('offer'));

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
				$filepath = public_path('img/docks/') . $file->getClientOriginalName();
				$file->move(public_path('img/docks'), $file->getClientOriginalName());

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

			//Get Provider Relation
			$provider = $this->getRelatedProvider($request->get('provider'));
			//Get Port Relation
			$port = $this->getRelatedPort($request->get('port'));

			//Update Dock fields
			$dock->getRelation("vendedorRelation")->add($provider);
			$dock->getRelation("puertoRelation")->add($port);
			$dock->set('provincia', $port->get('province'));

			try {
				//Update Port in Parse
				$dock->save();

				return redirect('docks')->with([
					'flash_message' => trans('messages.docks.updated'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('messages.docks.not-found'));
				}
				else {
					return redirect()->back()->withErrors(trans('parse.save') . $ex->getMessage());
				}
			}
		}
		else
		{
			return redirect('docks');
		}

	}

	public function unblock($id, Request $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner') || $current_user->hasRole('provider')){

			$this->validate($request, [
				'block-from' => 'required',
				'block-until' => 'required',
			]);

			//Query Dock
			$query = new ParseQuery('Atraques');
			//Get Dock by id
			$dock = $query->get($id);
			//New date
			$from = createDate($request->get('block-from'));
			$until = createDate($request->get('block-until'));

			$products = $this->getRelatedProducts($dock, $from, $until);

			foreach($products as $product)
			{
				if ($product->get('bloqueado')) {
					$product->set('reservado', false);
					$product->set('bloqueado', false);
				}
				else if ($product->get('confirmado')) {
					return redirect()->back()->withErrors(trans('messages.docks.not-unblocked'));
				}
				try {
					//Update product in Parse
					$product->save();

				} catch (ParseException $ex) {
					if ($ex->getCode() == 101){
						return redirect()->back()->withErrors(trans('messages.products.not-found'));
					}
					else {
						return redirect()->back()->withErrors(trans('parse.save') . $ex->getMessage());
					}
				}
			}
			return redirect('docks')->with([
				'flash_message' => trans('messages.docks.updated'),
				'flash_message_important' => true
				]);
		}
		else
		{
			return redirect('docks', $id);
		}
	}
	public function block($id, Request $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner') || $current_user->hasRole('provider')){

			$this->validate($request, [
				'block-from' => 'required',
				'block-until' => 'required',
			]);

			//Query Dock
			$query = new ParseQuery('Atraques');
			//Get Dock by id
			$dock = $query->get($id);

			//New date
			$from = createDate($request->get('block-from'));
			$until = createDate($request->get('block-until'));

			$products = $this->getRelatedProducts($dock, $from, $until);

			foreach($products as $product)
			{
				if ($product->get('confirmado') == false and $product->get('reservado') == false) {
					$product->set('reservado', true);
					$product->set('bloqueado', true);
				}
				else {
					return redirect()->back()->withErrors(trans('messages.docks.not-blocked'));
				}
				try {
					//Update product in Parse
					$product->save();

				} catch (ParseException $ex) {
					if ($ex->getCode() == 101){
						return redirect()->back()->withErrors(trans('messages.products.not-found'));
					}
					else {
						return redirect()->back()->withErrors(trans('parse.save') . $ex->getMessage());
					}
				}
			}
			return redirect('docks')->with([
				'flash_message' => trans('messages.docks.updated'),
				'flash_message_important' => true
				]);
		}
		else
		{
			return redirect('docks', $id);
		}

	}

	public function destroy($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Dock
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
					'flash_message' => trans('messages.docks.deleted'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {

				return redirect()->back()->withErrors(trans('messages.docks.parse') . $ex->getMessage());
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

	private function getRelatedPort($name = "current") {
		// Check if current user
		if ($name == null || $name == "current") {
			$provider = $this->getRelatedProvider();
			$port = $provider->get('puertoRelation')->getQuery()->find()[0];
		}
		else {
			$query = new ParseQuery('Puertos');
			$query->equalTo("name", $name);
			$ports = $query->find();
			$port = $ports[0];
		}

		return $port;
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

	private function getRelatedProvider($name = "current") {
		// Check if current user
		if ($name == null || $name == "current") {
			$name = Auth::user()->username;
		}

		$query = new ParseQuery('Vendedores');
		$query->equalTo("username", $name);

		$providers = $query->find();
		$provider = $providers[0];

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

	private function createProducts($dock, $start, $end, $price)
	{
		$day = $start;
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

	private function destroyProducts($dock, $start = null, $end = null)
	{

		$q = new ParseQuery('Productos');
		$q->equalTo('atraqueRelation', $dock);

		if($start) {
			$q->greaterThanOrEqualTo('fecha', $start);
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

	private function getRelatedProducts($dock, $start, $end)
	{

		//Query related products in date range
		$q = new ParseQuery('Productos');
		$q->equalTo('atraqueRelation', $dock);

		if($start) {
			$q->greaterThanOrEqualTo('fecha', $start);
		}
		if ($end) {
			$q->lessThanOrEqualTo('fecha', $end);
		}
		$products = $q->find();

		return $products;
	}

}
