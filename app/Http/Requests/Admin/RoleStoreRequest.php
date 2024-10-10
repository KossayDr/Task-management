<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
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

   
// this request is used for create role and permissions
    public function rules()
    {
        return [
            'permission'=>['required'],
            'permission.*'=>['exists:permissions,name'],
            'role' => ['required', 'unique:roles,name', 'max:20']
        ];
    }
}
