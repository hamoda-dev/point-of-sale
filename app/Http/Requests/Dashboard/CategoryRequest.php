<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
       $rules = [];

       if (request()->isMethod('post')) { // when create
           foreach (config('translatable.locales') as $locale) {
               $rules += [$locale . '.name' => 'required|unique:category_translations,name'];
           }
       } elseif (request()->isMethod('patch')) { // when update

           // get category id
           $path = explode('/', request()->requestUri);
           $categoryId = end($path);

           foreach (config('translatable.locales') as $locale) {
               $rules += [$locale . '.name' => 'required'];
               $rules += [$locale . '.name' => Rule::unique('category_translations', 'name')->ignore($categoryId, 'category_id')];
           }
       }


       return $rules;
    }
}
