<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class DockRequest extends Request {

	protected $dontFlash = [ 'image' ];

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
			'name' => 'required|min:8|max:40',
			'details' => 'required|min:20|max:300',
			'code' => 'required|min:6|max:40'
			'image' => 'required',
			'from' => 'required',
			'until' => 'required',
			'beam' => 'required',
			'length' => 'required',
			'draft' => 'required',
			'providers' => 'required|min:6',
			'ports' => 'required|min:6'
		];
	}

}
