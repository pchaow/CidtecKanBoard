<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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

        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|unique:roles,name|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $role = $this->get('id');

                return [
                    'name' => "required|unique:roles,name,$role|max:255",
                ];
            }
            default:break;
        }


    }
}
