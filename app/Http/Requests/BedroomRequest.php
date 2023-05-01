<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BedroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        $verb = $this->method();

        if ($verb === 'POST') {

            return [
                'code' => 'required|string|unique:bedrooms',
                'bed_number' => 'required|integer',
                'price' => 'required|integer',
                'type' => 'required|in:SHOWER,BATHTUB',
            ];
        } elseif ($verb === 'GET') {

            return [
                'code' => 'string',
                'bed_number' => 'integer',
                'price' => 'integer',
                'type' => 'in:SHOWER,BATHTUB'
            ];
        } else {

            return [
                'code' =>  [
                    'sometimes',
                    'required',
                    Rule::unique('bedrooms')->ignore($this->bedroom->id),
                ],
                'bed_number' => 'sometimes|required|integer',
                'price' => 'sometimes|required|integer',
                'type' => 'sometimes|required|in:SHOWER,BATHTUB',
            ];
        }

        return [];
    }
}
