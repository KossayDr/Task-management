<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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

  // this Request for permissions
    public function rules()
    {
        return [
            'permission' => ['exists:permissions,name','min:1'],

        ];
    }
}
