<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserBoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = Auth::user()->id;
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'name' => "required|max:255|unique:boards,name,NULL,id,user_id,$user_id|not_in:new,close"
                ];
            }
            case 'PUT':
            case 'PATCH': {
                $id = $this->get('id');

                return [
                    'name' => "required|max:255|unique:boards,name,$id,id,user_id,$user_id|not_in:new,close",
                ];
            }
            default:
                break;
        }
    }
}
