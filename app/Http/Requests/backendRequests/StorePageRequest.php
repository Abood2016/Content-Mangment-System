<?php

namespace App\Http\Requests\backendRequests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required|min:50',
            'status' => 'required',
            'category_id' => 'required',
            'images.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:30000',
        ];
    }
}
