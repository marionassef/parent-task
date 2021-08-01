<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'provider' => 'bail|nullable|string|max:100',
            'statusCode' => 'bail|nullable|string|'.Rule::in(["authorised", "decline", "refunded"]),
            'balanceMin' => 'bail|nullable|numeric',
            'balanceMax' => 'bail|numeric',
            'currency' => 'bail|nullable|string|max:10',
        ];
    }
}
