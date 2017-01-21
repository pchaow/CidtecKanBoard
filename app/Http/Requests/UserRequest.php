<?php

namespace App\Http\Requests;

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

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'email' => 'required|email|max:255|unique:users',
                    'username' => 'required|max:255|unique:users',
                    'name' => 'required|max:255',
                    'password' => 'required|min:6|confirmed',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                $user = $this->get('id');

                return [
                    'email' => "required|email|max:255|unique:users,email,$user",
                    'username' => "required|email|max:255|unique:users,username,$user",
                    'password' => 'min:6|confirmed|nullable|same:password_confirmation',
                    'name' => 'required|max:255',
                ];
            }
            default:
                break;
        }


    }
}
