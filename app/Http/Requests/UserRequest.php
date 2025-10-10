<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Bank;

class UserRequest extends FormRequest
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
		$userId = null;
		
		if ($this->isMethod('put')) {
			$userId = $this->route('user')->id; // Obtener el ID del usuario actualmente en edición
		}
		return [
			'name' => 'required|max:255',
			'email' => [
                'required',
                'string',
                'email',
                'max:255',
				Rule::unique('users')->ignore($userId), // Ignorar el correo electrónico del usuario actual
            ],
			'bank_account' => [
				'nullable',
				'numeric',
				'digits:18', 
			],
			'role_id' => 'required',
			'password' => ($this->isMethod('put') ? 'nullable|' : 'required|') . 'max:255', // Hacer el campo password opcional en edición
		];
	}

	public function attributes()
	{
		return [
			'name' => 'Nombre'
		];
	}


}