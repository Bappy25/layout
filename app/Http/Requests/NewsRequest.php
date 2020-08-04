<?php

namespace App\Http\Requests;

use App\Helpers\ApiHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewsRequest extends FormRequest
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
            'title' => 'required|string|max:1000',
            'tags' => 'required|string|max:255',
            'description' => 'required|string|max:10000',
        ];
    }

    public function withValidator($validator)
    {
        \Log::info('NewsRequest validation checked');
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiHelper::failedValidation($validator->errors(), 'News Validation Failed!'));
    }
}
