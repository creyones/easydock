<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Province;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller {

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show()
	{
		$user = Auth::user();
		return view ('pages.profile', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit()
	{
		//
		$user = Auth::user();
		return view ('pages.profile', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update(Request $request)
	{
		//
		$user = Auth::user();
		$user->firstname = $request->get('firstname');
		$user->lastname = $request->get('lastname');
		$user->phone = $request->get('phone');
		$user->mobile = $request->get('mobile');
		$user->address = $request->get('address');
		$user->city = $request->get('city');
		$user->postalcode = $request->get('postalcode');
		$user->port = $request->get('port');
		$user->save();

		return view('pages.profile', compact('user'))->with([
			'flash_message' => trans('messages.uses.updated'),
			'flash_message_important' => true
			]);;
	}

}
