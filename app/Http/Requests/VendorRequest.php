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
            'vend-mail' => 'sometimes|nullable|email',                      // VENDOR EMAIL INPUT
            'vend-cate' => 'required|exists:main_cates,id',                 // VENDOR CATEGORY SELECT INPUT
            'vend_logo' => 'required_without:edit|mimes:jpg,jpeg,png',      // VENDOR LOGO IMAGE INPUT
            'vend-mobi' => 'required|max:100',                              // VENDOR MOBILE INPUT
            'vend-addr' => 'required|string|max:500',                       // VENDOR ADDRESS INPUT
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
            'vend-name.string'      => 'Vendor\'s name must be letters',            // VENDOR NAME INPUT STRING MESSAGE
            'vend-name.max'         => 'Vendor\'s name max value is 100 character', // VENDOR NAME INPUT MAX MESSAGE

            'vend-stat.in'          => 'Status value isn\'t valid',                 // VENDOR STATUS CHECK INPUT MESSAGE

            'vend-mail.sometimes'   => 'Vendor\'s email is optional',           // VENDOR EMAIL INPUT SOMETIMES MESSAGE
            'vend-mail.nullable'    => 'Vendor\'s email is optional',           // VENDOR EMAIL INPUT NULLABLE MESSAGE
            'vend-mail.email'       => 'Please enter a valid vendor\'s email',  // VENDOR EMAIL INPUT EMAIL MESSAGE
            
            'vend-cate.required'    => 'Please select the category related to your business',   // VENDOR CATEGORY SELECT INPUT REQUIRED MESSAGE
            'vend-cate.exists'      => 'Invalid Category value',                                // VENDOR CATEGORY SELECT INPUT EXISTS MESSAGE

            'vend_logo.required_without'    => 'Please upload the vendor\'s logo',              // VENDOR LOGO IMAGE INPUT REQUIRED WITHOUT MESSAGE
            'vend_logo.mimes'               => 'Only "jpg", "jpeg", and "png" are available',   // VENDOR LOGO IMAGE INPUT MIMES MESSAGE

            'vend-mobi.required'    => 'Please enter the vendor\'s mobile number',      // VENDOR MOBILE INPUT REQUIRED MESSAGE
            'vend-mobi.max'         => 'Invalid mobile number',                         // VENDOR MOBILE INPUT MAX MESSAGE

            'vend-addr.required'    => 'Please Insert the vendor\'s address',   // VENDOR ADDRESS INPUT REQUIRED MESSAGE
            'vend-addr.string'      => 'Invalid address value',                 // VENDOR ADDRESS INPUT STRING MESSAGE
            'vend-addr.max'         => 'Invalid address value',                 // VENDOR ADDRESS INPUT MAX MESSAGE
        ];
    }
}
