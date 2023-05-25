<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
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

        $method = $this->method();

        if ($method === 'POST') {
            return [
                'bedroom_id' => 'required|integer|exists:bedrooms,id',
                'user_id' => 'required|integer|exists:users,id',
                'start_date' => 'required|date|after_or_equal:now|before:end_date',
                'end_date' => 'required|date|after:start_date',
            ];
        } elseif ($method === 'PUT') {
            return [
                'start_date' => 'sometimes|required_with:end_date|date|after_or_equal:now|before:end_date',
                'end_date' => 'sometimes|required_with:start_date|date|after:start_date',
                'validated' => 'sometimes|required|boolean'
            ];
        }


        return [];
    }
}
