<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\BookingRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseRelation;
use Parse\ParseException;

Use Carbon\Carbon;

class BookingsController extends Controller {

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
			$query = new ParseQuery('Solicitudes');
			$query->select(['nombrePuerto', 'userRelation', 'fechaInicio', 'fechaFinal']);
			$query->ascending('createdAt');

			$bookings = $query->find();

			return view('bookings.index', compact('bookings'));
		}
		else
		{
			return view('bookings.index');
		}
	}

	public function show($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Dock
			$query = new ParseQuery('Solicitudes');
			$query->equalTo("objectId", $id);

			$bookings = $query->find();

			//Query related Products
			$relQuery = new ParseQuery('Productos');
			$relQuery->matchesQuery('solicitudRelation', $query);

			$products = $relQuery->find();

			//No results
			if (count($bookings) <= 0)
			{
				return view('bookings.show')->withErrors(trans('validation.custom.not-found'));
			}

			$booking = $bookings[0];

			$dock = $booking->get('atraqueRelation')->getQuery()->find()[0];
			$user = $booking->get('userRelation')->getQuery()->find()[0];

			return view('bookings.show', compact('booking', 'user', 'dock', 'products'));
		}
		else
		{
			return view('bookings.show');
		}
	}

	public function create()
	{
		$docks = $this->listDocks();
		$users = $this->listUsers();

		//TODO create booking view

		return view('bookings.create', compact('docks', 'users'));
	}

	public function store(Request $request)
	{

		//Create Parse Booking
		//Temp Code
		$q = new ParseQuery('Atraques');
		$dock = $q->get('iMV2W3Lo9u');

		$query = ParseUser::query();
		$query->equalTo('username', 'jose');
		$user = $query->find()[0];

		$begin = createDate('22/04/2015');
		$end = createDate('24/04/2015');
		$iq = new ParseQuery('Solicitudes');
		$booking = $iq->get('GxA7inQKhs');
		$booking->set('fechaInicio', $begin);
		$booking->set('fechaFinal', $end);
		$booking->set('confirmado', false);
		$booking->set('nombrePuerto', 'Real Club Náutico de Tenerife');
		$booking->set('precioTotal', 220);
		$booking->getRelation('atraqueRelation')->add($dock);
		$booking->getRelation('userRelation')->add($user);

		try {

			$booking->save();

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
				$product->set('reservado', true);
				$product->getRelation('solicitudRelation')->add($booking);
				$product->save();
			}

			return redirect('bookings')->with([
				'flash_message' => trans('messages.booking_created'),
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
			$query = new ParseQuery('Solicitudes');

			try {
				//Get Port by id
				$booking = $query->get($id);

				$dock = $booking->get('atraqueRelation')->getQuery()->find()[0];
				$user = $booking->get('userRelation')->getQuery()->find()[0];

				//$docks = $this->listDocks($booking->get('nombrePuerto'));
				//$users = $this->listUsers();

				return view('bookings.edit', compact('booking', 'dock', 'user'));

			}
			catch (ParseException $ex) {
				if ($ex->getCode() == 101){
					return redirect()->back()->withErrors(trans('validation.custom.not-found'));
				}
			}
		}
		else
		{
			return view('bookings.edit');
		}
	}

	public function update($id, BookingRequest $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query Port
			$query = new ParseQuery('Solicitudes');
			//Get Port by id
			$booking = $query->get($id);

			//Previous date
			$pfrom = createDate($booking->get('fechaInicio')->format('d/m/Y'));
			$puntil = createDate($booking->get('fechaFinal')->format('d/m/Y'));

			//New date
			$from = createDate($request->get('from'));
			$until = createDate($request->get('until'));

			$modified = false;
			//Check if date has changed
			if ( $from->ne($pfrom) or $until->ne($puntil) )
			{
				//Query related dock
				$dock = $booking->get('atraqueRelation')->getQuery()->find()[0];

				//Number of days
				$days = $until->diffInDays($from) + 1;

				//Log::info('date has changed');

				//Free up existing products
				$this->freeProducts($booking, $pfrom, $puntil);

				//Query if dock is empty on these dates
				$q = new ParseQuery('Productos');
				$q->equalTo('atraqueRelation', $dock);
				$q->equalTo('reservado', false);
				$q->greaterThanOrEqualTo('fecha', $from);
				$q->lessThanOrEqualTo('fecha', $until);
				$count = $q->count();

				//Is available
				if($count == $days){

					//Log::info('products are available');
					//Book new products
					$price = $this->bookProducts($booking, $from, $until);

					//Update booking
					$booking->set('fechaInicio', $from);
					$booking->set('fechaFinal', $until);
					$booking->set('precioTotal', $price);
				}
				else {
					//Not available
					//Restore old products
					//Log::info('Restore old products');
					$this->bookProducts($booking, $pfrom, $puntil);

					return redirect()->back()->withErrors(trans('validation.custom.not-available'));
				}

				$modified = true;
			}

			//Set status
			if ($booking->get('confirmado') != ($request->get('confirmed') == '1'))
			{
				$booking->set('confirmado', $request->get('confirmed') == '1' ? true : false);
				if($request->get('confirmed') == '1') {
					$this->confirmProducts($booking);
				}
				else {
					$this->confirmProducts($booking, false);
				}


				//TODO send notification
				$modified = true;
			}

			if ($booking->get('precioTotal') != $request->get('price'))
			{
				$booking->set('precioTotal', floatval($request->get('price')));
				$modified = true;
			}

			try {
				//Update Booking in Parse
				if ($modified) {
					$booking->save();
				}
				else {
					return redirect()->back()->withErrors(trans('validation.custom.not-modified'));
				}

				return redirect('bookings')->with([
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
			return redirect('bookings');
		}

	}

	public function destroy($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')) {

			//Query Port
			$query = new ParseQuery('Solicitudes');
			//Get Port by id
			$booking = $query->get($id);
			$from = createDate($booking->get('fechaInicio')->format('d/m/Y'));
			$until = createDate($booking->get('fechaFinal')->format('d/m/Y'));

			try {

				//Free related Products
				$this->freeProducts($booking, $from, $until);

				//Destroy Port in Parse
				$booking->destroy();

				return redirect('bookings')->with([
					'flash_message' => trans('messages.booking_deleted'),
					'flash_message_important' => true
					]);

			} catch (ParseException $ex) {

				return redirect()->back()->withErrors(trans('validation.custom.parse') . $ex->getMessage());
			}
		}
		else
		{
			return redirect('bookings');
		}
	}


	private function listUsers()
	{
		$query = ParseUser::query();
		$query->notEqualTo('username', 'admin');
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

	private function listDocks()
	{
		$query = new ParseQuery('Atraques');
		$query->select('name');
		$query->ascending("name");
		$query->limit(50);
		$items = $query->find();
		$count = $query->count();

		$docks = [];
		for ($i = 0; $i < $count; ++$i)
		{
			$docks[$items[$i]->get('name')] = $items[$i]->get('name');
		}
		return $docks;
	}

	private function bookProducts($booking, $begin, $end)
	{
		$q = new ParseQuery('Productos');
		$q->greaterThanOrEqualTo('fecha', $begin);
		$q->lessThanOrEqualTo('fecha', $end);
		$q->limit( $end->diffInDays($begin) + 1 );
		$products = $q->find();

		$price = 0;

		foreach ($products as $product)
		{
			$price += floatval($product->get('precio'));
			$product->set('confirmado', false);
			$product->set('reservado', true);
			$product->getRelation('solicitudRelation')->add($booking);

			$product->save();
		}

		return $price;
		//dd($products);
	}

	private function freeProducts($booking, $begin, $end)
	{

		$q = new ParseQuery('Productos');
		$q->equalTo('solicitudRelation', $booking);
		$q->greaterThanOrEqualTo('fecha', $begin);
		$q->lessThanOrEqualTo('fecha', $end);
		$q->limit( $end->diffInDays($begin) + 1 );

		$products = $q->find();

		foreach($products as $product)
		{
			$product->set('reservado', false);
			$product->getRelation('solicitudRelation')->remove($booking);
			$product->save();
		}

		//Log::info('freeProducts (' .$begin->toDateString().':' .$end->toDateString(). ')');
		//dd($products);
	}

	private function confirmProducts($booking, $val = true)
	{
		$q = new ParseQuery('Productos');
		$q->equalTo('solicitudRelation', $booking);
		$products = $q->find();

		foreach ($products as $product)
		{
			$product->set('confirmado', $val);
			$product->set('reservado', true);

			$product->save();
		}

	}

}
