<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequisitionRequest extends FormRequest
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
	 * 
	 * @return array
	 */
	public function rules()
	{
		return [
			'payment_type_id' => 'required|exists:payment_types,id',
			'branch_id' => 'required|exists:branches,id',
			'application_date' => 'required|date',

			// Validación para filas principales
			'rows' => 'required|array',
			'rows.*.supplier_id' => 'required|exists:suppliers,id',
			'rows.*.description' => 'required|string',
			'rows.*.unit_price' => 'required|numeric',
			'rows.*.url' => 'nullable|url',
			
			// Validación para filas opcionales
			'optional_rows' => 'nullable|array',
			'optional_rows.*.supplier_id' => 'required|exists:suppliers,id',
			'optional_rows.*.description' => 'required|string',
			'optional_rows.*.unit_price' => 'required|numeric',
			'optional_rows.*.url' => 'nullable|url',
		];
	}


	public function attributes()
	{
		return [
			'name' => 'Nombre'
		];
	}
}
