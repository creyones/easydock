<?php namespace App\Http\Controllers;

//require_once '../vendor/autoload.php';

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;

class PagesController extends Controller {

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}

	//
	public function home()
	{

		$current_user = Auth::user();

		//Query Docks
		$docks = new ParseQuery('Productos');
		$docks->ascending('createdAt');

		//Query Requests
		$bookings = new ParseQuery('Solicitudes');
		$bookings->ascending('createdAt');

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query App Users
			$users = ParseUser::query();
			$users->ascending('createdAt');
			$users->notEqualTo('username', 'administrator');

			//Query Providers
			$providers = new ParseQuery('Vendedores');
			$providers->ascending('createdAt');

			//Query Ports
			$ports = new ParseQuery('Puertos');
			$ports->ascending('createdAt');

			return view('home', compact('users', 'providers', 'ports', 'docks', 'bookings'));
		}
		else {

			return view('home', compact('docks', 'bookings'));
		}

	}

}
