<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\People;

class UserRequest extends FormRequest
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

            if ($routeName === 'users.store') {

                return [
                    'username' => 'required|string|unique:users',
                    'firstname' => 'required|string',
                    'lastname' => 'required|string',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|string',
                    'avatar' => 'required|string',
                ];
            } elseif ($routeName === 'users.avatar') {

                return [
                    'avatar_file' => 'required|image'
                ];
            }
        } elseif ($verb === 'GET') {

            return [
                'username' => 'string',
                'firstname' => 'string',
                'lastname' => 'string',
                'email' => 'string'
            ];
        } else {

            $user = $this->route('user');

            return [
                'username' => [
                    'sometimes',
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
                'firstname' => 'sometimes|required|string',
                'lastname' => 'sometimes|required|string',
                'email' => [
                    'sometimes',
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
                'password' => 'sometimes|required|string',
                'avatar' => 'sometimes|required|image',
            ];
        }

        return [];
    }
}
