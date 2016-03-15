<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PortRequest extends Request {

	protected $dontFlash = [ 'plan' ];

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
		if(str_contains(Request::route()->getAction()['uses'],'update'))
		{
			$image_rule = '';
		}
		else $image_rule = 'required|max:1000';
		return [
			'name' => 'required|min:8|max:40',
			'provinces' => 'required',
			'latitude' => 'required|min:6',
			'longitude' => 'required|min:6',
			'plan' => $image_rule,
		];
	}

}
