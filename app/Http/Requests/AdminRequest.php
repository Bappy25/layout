<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        switch($this->method()){
            case 'POST':
            {
                return [
                    'name' => 'required|string|min:3|max:255',
                    'email' => 'required|string|email|max:50|unique:admins',
                    'password' => 'required|min:4|max:150|confirmed',
                ];
            }
            case 'PUT':
            {
                return [
                    'name' => 'required|string|min:3|max:255',
                    'email' => 'required|string|email|max:50|unique:admin,email,'.\Request::instance()->admin.',id',
                    'password' => 'sometimes|nullable|min:4|max:150|confirmed',
                ];
            }
            default:break;
        }
    }
}
