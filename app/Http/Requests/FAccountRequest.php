<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class FAccountRequest extends FormRequest
{
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
			'name' => 'required|max:255',
			'account_number' => 'required|max:255',
			'balance' => 'required|numeric',

		];
	}

	public function attributes()
	{
		return [
			'name' => 'Nombre',
			'account_number' => 'Número de cuenta',
			'balance' => 'Saldo'

		];
	}
}