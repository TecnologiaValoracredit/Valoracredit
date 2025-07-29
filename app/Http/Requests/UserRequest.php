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
				//Si los primero 3 numeros de bank_account es igual a bank_code
				 function ($attribute, $value, $fail) {
					$bankId = $this->input('bank_id'); // obtener bank_id desde el request

					$bank = Bank::find($bankId);

					if (!$bank) {
						$fail('El banco no existe.');
						return;
					}

					$accountPrefix = substr($value, 0, 3);

					if ($accountPrefix !== $bank->bank_code) {
						$fail("El número de cuenta no coincide con el código del banco ({$bank->bank_code}).");
					}
				}
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