<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

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
        if (request()->isMethod("post")) { // when create
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ];
        } elseif (request()->isMethod('patch')) {  // when update
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
            ];
        }

    }
}
