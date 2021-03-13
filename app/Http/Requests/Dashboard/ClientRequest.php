<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $rules = [];

        foreach (config(key: 'translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required'];
            $rules += [$locale . '.address' => 'required'];
//           $rules += [$locale . '.name' => [Rule::unique('category_translations')]];
        }

        $rules += ['phone' => 'required'];

        return $rules;
    }
}
