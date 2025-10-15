<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequisitionRowsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product' => 'required|string|max:255',
            'product_description' => 'required|string|max:500',
            'product_quantity' => 'required|numeric|min:1',
            'product_cost' => 'required|numeric|min:0',
            // 'has_iva' => 'required|boolean',
            'total_cost' => 'required|numeric|min:0',
            'reason' => 'required|string|max:500',
            'evidence' => 'required|file|max:5120', // 5MB, ajusta según tus necesidades
            'link' => 'nullable|url',
            'currency_type_id' => 'required|integer|exists:currency_types,id',
            // 'requisition_id' => 'required|integer|exists:requisitions,id',
            // 'parent_id' => 'nullable|integer',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            // 'is_active' => 'nullable|boolean',
            // 'created_by' => 'nullable|integer',
            // 'updated_by' => 'nullable|integer',
            // 'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages()
{
    return [
        'product.required' => 'El campo Producto es obligatorio.',
        'product_description.required' => 'Debes escribir una descripción del producto.',
        'product_quantity.required' => 'La cantidad es obligatoria.',
        'product_quantity.numeric' => 'La cantidad debe ser un número.',
        'product_cost.required' => 'El costo unitario es obligatorio.',
        'has_iva.required' => 'Indica si incluye IVA.',
        'total_cost.required' => 'El total es obligatorio.',
        'reason.required' => 'Debes indicar la razón de la compra.',
        'evidence.required' => 'Debes adjuntar un archivo de evidencia.',
        'currency_type_id.required' => 'Selecciona un tipo de moneda.',
        'supplier_id.required' => 'Selecciona un proveedor.',
        'link.url' => 'El enlace debe tener un formato válido (https://...).',
    ];
}
}
