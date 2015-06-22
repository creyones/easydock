<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderRequest extends Request {

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
		if ($this->method() == 'PATCH')
  	{
    	// Update operation, exclude the record with id from the validation:
    	$email_rule = 'required|email';
			$password_rule = '';
  	}
  	else
  	{
    	// Store operation. There is no id yet.
    	$email_rule = 'required|email|unique:users,email';
			$password_rule = 'required|min:8';
  	}

		return [
			//
			'email' => $email_rule,
			'username' => 'required|min:4',
			'password' => $password_rule,
			'port' = 'required'
		];
	}

}
