<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'productName' => ['required', 'max:255'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'decimal:2']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_name' => $this->productName
        ]);
    }
}
