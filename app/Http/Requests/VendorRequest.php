<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
        return [
            // RULES FOR VENDORS CREATION FORM
            'vend-name' => 'required|string|max:100',                       // VENDOR NAME INPUT
            'vend-stat' => 'in:0,1',                                        // VENDOR STATUS CHECK INPUT
            // 'vend-mail' => 'sometimes|nullable|email',                      // VENDOR EMAIL INPUT
            'vend-mail' => 'required|unique:vendors,email|email',           // VENDOR EMAIL INPUT
            'vend-cate' => 'required|exists:main_cates,id',                 // VENDOR CATEGORY SELECT INPUT
            'vend_logo' => 'required_without:edit|mimes:jpg,jpeg,png',      // VENDOR LOGO IMAGE INPUT
            'vend-mobi' => 'required|unique:vendors,mobile|max:14|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',   // VENDOR MOBILE INPUT
            'vend-addr' => 'required|string|max:500',                       // VENDOR ADDRESS INPUT
            'vend-pass' => 'required|string|min:6',                         // VENDOR PASSWORD INPUT
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // MESSAGES FOR VENDORS CREATION FORM
            'vend-name.required'    => 'Please enter the vendor\'s name',           // VENDOR NAME INPUT REQUIRED MESSAGE
            'vend-name.string'      => 'Name must be letters',                      // VENDOR NAME INPUT STRING MESSAGE
            'vend-name.max'         => 'Name max value is 100 character',           // VENDOR NAME INPUT MAX MESSAGE

            'vend-stat.in'          => 'Status value isn\'t valid',                         // VENDOR STATUS CHECK INPUT MESSAGE

            // 'vend-mail.sometimes'   => 'Vendor\'s email is optional',                    // VENDOR EMAIL INPUT SOMETIMES MESSAGE
            // 'vend-mail.nullable'    => 'Vendor\'s email is optional',                    // VENDOR EMAIL INPUT NULLABLE MESSAGE
            'vend-mail.required'    => 'Vendor\'s email is mandatory',                      // VENDOR EMAIL INPUT REQUIRED MESSAGE
            'vend-mail.unique'      => 'Already registered try another one',                // VENDOR EMAIL INPUT UNIQUE MESSAGE
            'vend-mail.email'       => 'Please enter a valid email',                        // VENDOR EMAIL INPUT EMAIL MESSAGE
            
            'vend-cate.required'    => 'Please select the business related category',           // VENDOR CATEGORY SELECT INPUT REQUIRED MESSAGE
            'vend-cate.exists'      => 'Invalid Category value',                                // VENDOR CATEGORY SELECT INPUT EXISTS MESSAGE

            'vend_logo.required_without'    => 'Please upload the vendor\'s logo',              // VENDOR LOGO IMAGE INPUT REQUIRED WITHOUT MESSAGE
            'vend_logo.mimes'               => 'Only "jpg", "jpeg", & "png" are available',     // VENDOR LOGO IMAGE INPUT MIMES MESSAGE

            'vend-mobi.required'    => 'Please enter a valid number',               // VENDOR MOBILE INPUT REQUIRED MESSAGE
            'vend-mobi.unique'      => 'Already registered try another one',        // VENDOR MOBILE INPUT UNIQUE MESSAGE
            'vend-mobi.max'         => 'Invalid mobile number',                     // VENDOR MOBILE INPUT MAX MESSAGE
            'vend-mobi.regex'       => 'Invalid mobile number',                     // VENDOR MOBILE INPUT REGEX MESSAGE
            'vend-mobi.not_regex'   => 'Invalid mobile number',                     // VENDOR MOBILE INPUT NOT REGEX MESSAGE

            'vend-addr.required'    => 'Please Insert the vendor\'s address',   // VENDOR ADDRESS INPUT REQUIRED MESSAGE
            'vend-addr.string'      => 'Invalid address value',                 // VENDOR ADDRESS INPUT STRING MESSAGE
            'vend-addr.max'         => 'Invalid address value',                 // VENDOR ADDRESS INPUT MAX MESSAGE

            'vend-pass.required'    => 'Please initiate the vendor\'s password',      // VENDOR PASSWORD INPUT REQUIRED MESSAGE
            'vend-pass.string'      => 'Invalid input value',                         // VENDOR PASSWORD INPUT STRING MESSAGE
            'vend-pass.min'         => 'Password must be at least 6 characters',      // VENDOR PASSWORD INPUT MINIMUM CHARACTERS MESSAGE
        ];
    }
}
