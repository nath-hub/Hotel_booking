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

            $routeName = $this->route()->getName();

            if ($routeName === 'bedrooms.images') {

                return [
                    'images' => 'required|image',
                    'imagesShower' => 'required|image',
                ];
            } else {

                return [
                    'code' => 'required|string|unique:bedrooms',
                    'bed_number' => 'required|integer',
                    'price' => 'required|integer',
                    'type' => 'required|in:SHOWER,BATHTUB',
                    'images' => 'required|string',
                    'imagesShower' => 'required|string',
                ];
            };
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
                    Rule::unique('bedrooms')->ignore($this->route('bedroom')->id),
                ],
                'bed_number' => 'sometimes|required|integer',
                'price' => 'sometimes|required|integer',
                'type' => 'sometimes|required|in:SHOWER,BATHTUB',
                'images' => 'sometimes|required|string',
                'imagesShower' => 'sometimes|required|string',
            ];
        }

        return [];
    }
}
