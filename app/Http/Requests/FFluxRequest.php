<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class FFluxRequest extends FormRequest
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
			
			'accredit_date' => 'required',
			'concept' => 'required|max:255',
			'amount' => 'required|numeric',
			'f_beneficiary_id' => 'required',
			'f_movement_type_id' => 'required'
		];
	}

	public function attributes()
	{
		return [
			

		];
	}
}