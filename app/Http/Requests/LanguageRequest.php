<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            // LANGUAGES VALIDATION RULES
            'lang-name' => 'required|max:100',   // LANGUAGE NAME
            'lang-abbr' => 'required|string|max:10',    // LANGUAGE ABBREVIATION
            'lang-dire' => 'required|in:ltr,rtl',       // LANGUAGE DIRECTION
            'lang-stat' => 'required|in:0,1',           // LANGUAGE STATUS
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
            // LANGUAGES VALIDATION MESSAGES
            'lang-name.required'    => 'Please enter the language name',                        // LANGUAGE REQUIRED NAME MESSAGE
            'lang-name.string'      => 'Language name must be letters',                         // LANGUAGE STRING NAME MESSAGE
            'lang-name.max'         => 'Language name must be at least 100 characters',         // LANGUAGE MAX LENGTH NAME MESSAGE
            'lang-abbr.required'    => 'Please enter the language abbreviation',                // LANGUAGE REQUIRED ABBREVIATION MESSAGE
            'lang-abbr.string'      => 'Language abbreviation must be letters',                 // LANGUAGE STRING ABBREVIATION MESSAGE
            'lang-abbr.max'         => 'Abbreviation name must be at least 10 characters',     // LANGUAGE MAX LENGTH ABBREVIATION MESSAGE
            'lang-dire.required'    => 'Please select the language direction',                  // LANGUAGE REQUIRD DIRECTION MESSAGE
            'lang-dire.in'          => 'Please select one of the two previous options',         // LANGUAGE DIRECTION OPTIONS MESSAGE
            'lang-stat.required'    => 'Please slide to activate the language',                 // LANGUAGE REQUIRED STATUS MESSAGE
            'lang-stat.in'          => 'The value entered is invalid',                          // LANGUAGE STATUS OPTIONS MESSAGE
        ];
    }
}
