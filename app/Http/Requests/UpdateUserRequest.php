<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'name' => [
                'required', 'string',
            ],
            'email' => [
                'required', 'email', 'unique:users,email,' . request()->route('user'),
            ],
            'role_id' => [
                'integer', 'in:' . Role::pluck('id')->implode(','),
            ],
        ];
    }
}
