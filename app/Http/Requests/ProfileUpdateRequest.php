<?php

namespace App\Http\Requests;

use App\Models\EmpAcc;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'emp_user' => ['required', 'string', 'max:255'],
            'emp_email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(emp_acc::class, 'emp_email')->ignore($this->user()->empid, 'empid')],
        ];
    }
}
