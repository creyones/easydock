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
		//Home page presentation
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){
			//Query Docks
			$docks = new ParseQuery('Atraques');
			$docks->ascending('createdAt');

			//Query Requests
			$bookings = new ParseQuery('Solicitudes');
			$bookings->ascending('createdAt');

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
		else if ($current_user->hasRole('provider')) {
			$provider = $this->getCurrentProvider();

			$docks = new ParseQuery('Atraques');
			$docks->equalTo('vendedorRelation', $provider);
			$docks->ascending('createdAt');

			//Related docks to provider
			$queries = [];
			$results = $docks->find();

			if(count($results) > 0) {
				foreach ($results as $dock) {
					$query = new ParseQuery('Solicitudes');
					$query->equalTo('atraqueRelation', $dock);
					array_push($queries, $query);
				}
				$bookings = ParseQuery::orQueries($queries);
			}
			else {
				$bookings = array();
			}

			return view('home', compact('docks', 'bookings'));
		}
		else {
			return view('home', compact('docks', 'bookings'));
		}

	}

	private function getCurrentProvider() {
		//Query provider
		$rel = new ParseQuery('Vendedores');
		$rel->equalTo('username', Auth::user()->username);
		$provider = $rel->find()[0];

		return $provider;
	}

}
