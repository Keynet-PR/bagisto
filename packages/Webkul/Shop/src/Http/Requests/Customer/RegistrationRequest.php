<?php

namespace Webkul\Shop\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Customer\Facades\Captcha;

class RegistrationRequest extends FormRequest
{
    /**
     * Define your rules.
     *
     * @var array
     */
      private $rules = [
        'first_name' => 'required|string',
        'last_name'  => 'required|string',
        'phone'      => 'required|string|min:9|max:10|unique:customers,phone',
        'email'      => 'nullable|email|unique:customers,email',
        'password'   => 'required|confirmed|min:6',
    ];
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
        return Captcha::getValidations($this->rules);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return Captcha::getValidationMessages();
    }
}
