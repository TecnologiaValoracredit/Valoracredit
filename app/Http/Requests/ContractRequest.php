<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $contract_type_id
 * @property string $content
 */

class ContractRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'contract_type_id' => 'required',
            'content' => 'nullable',
        ];
    }

    public function attributes(){
        return [
            'name' => 'Nombre',
        ];
    }
}
