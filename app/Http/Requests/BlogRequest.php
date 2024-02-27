<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>['required','max:255'],
            'slug'=>['required','max:255',Rule::unique('blogs')->ignore($this->blog)],
            'description' => ['nullable'],
            'image'=> $this->isMethod('POST') ? 'required':'nullable',
            'image.*' => [ 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ];
    }
}
