<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCateRequest extends FormRequest
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
            // MAIN CATEGORIES VALIDATION RULES OF CREATE
            'cate-bags'             => 'required|array|min:1',              // MAIN CATEGORY ARRAY OF OBJECTS
            'cate-bags.*.cate-name' => 'required|string|max:100',           // MAIN CATEGORY NAMES
            'cate-bags.*.cate-abbr' => 'required|string|max:10',            // MAIN CATEGORY ABBREVIATIONS
            'cate-bags.*.cate-stat' => 'required|in:0,1',                   // MAIN CATEGORY STATUSES
            'cate-imag'             => 'required|mimes:jpg,jpeg,png',       // MAIN CATEGORY IMAGE
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
            // MAIN CATEGORIES VALIDATION MESSAGES OF CREATE
            'cate-bags.required'    => 'Please fulfill the category package',   // MAIN CATEGORY BAGS REQUIRED MESSAGE
            'cate-bags.array'       => 'Please fulfill the category package',   // MAIN CATEGORY BAGS ARRAY MESSAGE
            'cate-bags.min'         => 'Please fulfill the category package',   // MAIN CATEGORY MIN ONE BAG MESSAGE

            'cate-bags.*.cate-name.required'    => 'Please enter the category name',                    // MAIN CATEGORY REQUIRED NAME MESSAGE
            'cate-bags.*.cate-name.string'      => 'Category name must be letters',                     // MAIN CATEGORY STRING NAME MESSAGE
            'cate-bags.*.cate-name.max'         => 'Category name must be at least 100 characters',     // MAIN CATEGORY MAX LENGTH NAME MESSAGE

            'cate-bags.*.cate-abbr.required'    => 'Please enter the language abbreviation',                // MAIN CATEGORY REQUIRED ABBREVIATION MESSAGE
            'cate-bags.*.cate-abbr.string'      => 'Language abbreviation must be letters',                 // MAIN CATEGORY STRING ABBREVIATION MESSAGE
            'cate-bags.*.cate-abbr.max'         => 'Abbreviation name must be at least 10 characters',      // MAIN CATEGORY MAX LENGTH ABBREVIATION MESSAGE
            
            'cate-bags.*.cate-stat.required'    => 'Please slide to activate the language',                 // MAIN CATEGORY REQUIRED STATUS MESSAGE
            'cate-bags.*.cate-stat.in'          => 'The value entered is invalid',                          // MAIN CATEGORY STATUS OPTIONS MESSAGE

            'cate-imag.required'    => 'Please insert a category image',                                    // MAIN CATEGORY IMAGE REQUIRED MESSAGE
            'cate-imag.mimes'       => '"jpg", "jpeg", and "png" only are the available extensions',        // MAIN CATEGORY IMAGE EXTENSIONS MESSAGE
        ];
    }

}
