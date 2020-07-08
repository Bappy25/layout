<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\User;
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
        switch($this->method()){
            case 'POST':
            {
                return [
                    'name' => 'required|string|min:3|max:255',
                    'username' => 'required|string|max:50|unique:users',
                    'email' => 'required|string|email|max:50|unique:users',
                    'contact' => 'string|max:20|min:7|unique:user_details',
                    'dob' => 'date_format:d/m/Y|before_or_equal:'.Carbon::now()->subYears(18)->format('d/m/Y'),
                    'gender' => 'numeric',
                    'address' => 'string|max:500',
                    'password' => 'required|min:4|max:150|confirmed',
                ];
            }
            case 'PUT':
            {
                $user = User::where('id', $this->route('user'))->get()->first();
                return [
                    'name' => 'required|string|min:3|max:255',
                    'username' => 'required|string|max:50|unique:users,username,'.$user->id.',id',
                    'email' => 'required|string|email|max:50|unique:users,email,'.$user->id.',id',
                    'contact' => 'string|max:20|min:7|unique:user_details,contact,'.$user->id.',user_id',
                    'dob' => 'date_format:d/m/Y|before_or_equal:'.Carbon::now()->subYears(18)->format('d/m/Y'),
                    'gender' => 'numeric',
                    'address' => 'string|max:500',
                    'password' => 'sometimes|nullable|min:4|max:150|confirmed',
                ];
            }
            default:break;
        }
    }
}
