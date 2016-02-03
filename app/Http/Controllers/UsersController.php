<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseCloud;

use Request;

class UsersController extends Controller {

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

			//Query App Users
			$query = ParseUser::query();
			$query->ascending('createdAt');
			$query->notEqualTo('username', 'administrator');
			$query->select(['username', 'email', 'profile']);
			$query->limit(1000);

			$users = $query->find();

			return view('users.index', compact('users'));
		}
		else
		{
			return view('users.index');
		}
	}

	public function create()
	{
		return view('users.create');
	}

	public function store(UserRequest $request)
	{

		//$input = $request::all();
		$user = new ParseUser();
		$user->set('username', $request->get('username'));
		$user->set('password', $request->get('password'));
		$user->set('email', $request->get('email'));

		try {
			$user->signUp();
			return redirect('users')->with([
				'flash_message' => trans('messages.users.created'),
				'flash_message_important' => true
				]);
			// Hooray! Let them use the app now.
		} catch (ParseException $ex) {
			// Show the error message somewhere and let the user try again.
			//Session::flash('error', $ex->getMessage());
			//return redirect('users');
			if ($ex->getCode() == 202){
				return redirect()->back()->withErrors(trans('validation.custom.username.unique'));
			}
			elseif ($ex->getCode() == 203){
				return redirect()->back()->withErrors(trans('validation.custom.email.unique'));
			}
			else{
				return redirect()->back()->withErrors(trans('validation.custom.parse.save'));
			}
		}
	}

	public function show($id){

		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query App User
			$query = ParseUser::query();
			$query->equalTo("objectId", $id);

			$users = $query->find();

			//No results
			if (count($users) <= 0)
			{
				return view('users.show')->withErrors(trans('validation.users.not-found'));
			}

			$user = $users[0];

			$relQuery = new ParseQuery('Solicitudes');
			$relQuery->matchesQuery('userRelation', $query);

			$bookings = $relQuery->find();

			return view('users.show', compact('user', 'bookings'));
		}
		else
		{
			return view('users.show');
		}
	}

	public function edit($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Query App User
			$query = ParseUser::query();
			$query->equalTo("objectId", $id);

			$user = $query->find()[0];

			return view('users.edit', compact('user'));
		}
		else
		{
			return view('users.edit');
		}
	}

	public function update($id, UserRequest $request)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//Update App User
			//TODO Call to CloudCode function
			//$result = ParseCloud::run('updateUser', ['objectId', $id], true);

			return redirect('users')->with([
				'flash_message' => trans('messages.users.updated'),
				'flash_message_important' => true
				]);
		}
		else
		{
			return redirect('users');
		}

	}


	public function destroy($id)
	{
		$current_user = Auth::user();

		if ($current_user->hasRole('admin') || $current_user->hasRole('owner')){

			//TODO Call to CloudCode function
			//$result = ParseCloud::run('deleteUser', ['objectId', $id], true);

			//dd($id);

			return redirect('users')->with([
				'flash_message' => trans('messages.users.deleted'),
				'flash_message_important' => true
				]);
		}
		else
		{
			return redirect('users');
		}
	}

}
