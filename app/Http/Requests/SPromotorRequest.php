<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SPromotorRequest extends FormRequest
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
			// 'user_id' => 'required',
			'coordinator_id' => 'required',
			'promotor_credisoft_id' => 'numeric',
			'commission_percentage' => 'numeric',
			's_branch_id' => 'required|numeric',
			
		];
	}

	public function attributes()
	{
		return [
			'name' => 'Nombre',
			'user_id' => 'Usuario',
			'coordinator_id' => 'Coordinador',
			'promotor_credisoft_id' => 'Id en CrediSoft',
			'commission_percentage' => 'Porcentaje de comisión',
			's_branch_id' => 'Sucursal',
		];
	}
}
