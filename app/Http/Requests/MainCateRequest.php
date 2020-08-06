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
            // MAIN CATEGORIES VALIDATION RULES OF CREATE AND EDIT FORMS
            'cate_bags'             => 'required|array|min:1',                              // MAIN CATEGORY ARRAY OF OBJECTS
            'cate_bags.*.cate_name' => 'required|string|max:100',                           // MAIN CATEGORY NAMES
            'cate_bags.*.cate_abbr' => 'required|string|max:10',                            // MAIN CATEGORY ABBREVIATIONS
            'cate_bags.*.cate_stat' => 'required_without:edit|in:0,1',                      // MAIN CATEGORY STATUSES
            'cate_imag'             => 'required_without:edit|mimes:jpg,jpeg,png',          // MAIN CATEGORY IMAGE
            
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
            // MAIN CATEGORIES VALIDATION MESSAGES OF CREATE AND EDIT FORMS
            'cate_bags.required'    => 'Please fulfill the category package',   // MAIN CATEGORY BAGS REQUIRED MESSAGE
            'cate_bags.array'       => 'Please fulfill the category package',   // MAIN CATEGORY BAGS ARRAY MESSAGE
            'cate_bags.min'         => 'Please fulfill the category package',   // MAIN CATEGORY MIN ONE BAG MESSAGE

            'cate_bags.*.cate_name.required'    => 'Please enter the category name',                    // MAIN CATEGORY REQUIRED NAME MESSAGE
            'cate_bags.*.cate_name.string'      => 'Category name must be letters',                     // MAIN CATEGORY STRING NAME MESSAGE
            'cate_bags.*.cate_name.max'         => 'Category name must be at most 100 characters',     // MAIN CATEGORY MAX LENGTH NAME MESSAGE

            'cate_bags.*.cate_abbr.required'    => 'Please enter the language abbreviation',                // MAIN CATEGORY REQUIRED ABBREVIATION MESSAGE
            'cate_bags.*.cate_abbr.string'      => 'Language abbreviation must be letters',                 // MAIN CATEGORY STRING ABBREVIATION MESSAGE
            'cate_bags.*.cate_abbr.max'         => 'Abbreviation name must be at least 10 characters',      // MAIN CATEGORY MAX LENGTH ABBREVIATION MESSAGE
            
            'cate_bags.*.cate_stat.required_without'    => 'Please slide to activate the translated category',          // MAIN CATEGORY REQUIRED STATUS MESSAGE
            'cate_bags.*.cate_stat.in'                  => 'The value entered is invalid',                              // MAIN CATEGORY STATUS OPTIONS MESSAGE

            'cate_imag.required_without'    => 'Please insert a category image',                         // MAIN CATEGORY IMAGE REQUIRED MESSAGE
            'cate_imag.mimes'               => 'only "jpg", "jpeg", and "png" are the available',        // MAIN CATEGORY IMAGE EXTENSIONS MESSAGE

        ];
    }

}
