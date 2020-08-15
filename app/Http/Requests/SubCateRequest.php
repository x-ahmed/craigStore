<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCateRequest extends FormRequest
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
            // SUB CATEGORIES VALIDATION RULES OF CREATE AND EDIT FORMS
            'cate_bags'             => 'required|array|min:1',                              // SUB CATEGORY ARRAY OF OBJECTS
            'cate_bags.*.cate_name' => 'required|string|max:100',                           // SUB CATEGORY NAMES
            'cate_bags.*.cate_abbr' => 'required|string|max:10',                            // SUB CATEGORY ABBREVIATIONS
            'cate_bags.*.cate_stat' => 'required_without:edit|in:0,1',                      // SUB CATEGORY STATUSES
            'cate_imag'             => 'required_without:edit|mimes:jpg,jpeg,png',          // SUB CATEGORY IMAGE
            'main_cate'             => 'required|exists:main_cates,id',                     // SUB CATEGORY RELATED MAIN CATEGORY
            
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
            // SUB CATEGORIES VALIDATION MESSAGES OF CREATE AND EDIT FORMS
            'cate_bags.required'    => 'Please fulfill the category package',   // SUB CATEGORY BAGS REQUIRED MESSAGE
            'cate_bags.array'       => 'Please fulfill the category package',   // SUB CATEGORY BAGS ARRAY MESSAGE
            'cate_bags.min'         => 'Please fulfill the category package',   // SUB CATEGORY MIN ONE BAG MESSAGE

            'cate_bags.*.cate_name.required'    => 'Please enter the category name',                    // SUB CATEGORY REQUIRED NAME MESSAGE
            'cate_bags.*.cate_name.string'      => 'Category name must be letters',                     // SUB CATEGORY STRING NAME MESSAGE
            'cate_bags.*.cate_name.max'         => 'Category name must be at most 100 characters',     // SUB CATEGORY MAX LENGTH NAME MESSAGE

            'cate_bags.*.cate_abbr.required'    => 'Please enter the language abbreviation',                // SUB CATEGORY REQUIRED ABBREVIATION MESSAGE
            'cate_bags.*.cate_abbr.string'      => 'Language abbreviation must be letters',                 // SUB CATEGORY STRING ABBREVIATION MESSAGE
            'cate_bags.*.cate_abbr.max'         => 'Abbreviation name must be at least 10 characters',      // SUB CATEGORY MAX LENGTH ABBREVIATION MESSAGE
            
            'cate_bags.*.cate_stat.required_without'    => 'Please slide to activate the translated category',          // SUB CATEGORY REQUIRED STATUS MESSAGE
            'cate_bags.*.cate_stat.in'                  => 'The value entered is invalid',                              // SUB CATEGORY STATUS OPTIONS MESSAGE

            'cate_imag.required_without'    => 'Please insert a category image',                         // SUB CATEGORY IMAGE REQUIRED MESSAGE
            'cate_imag.mimes'               => 'Only "jpg", "jpeg", and "png" are available',            // SUB CATEGORY IMAGE EXTENSIONS MESSAGE

            'main_cate.required'    => 'Please select the related category',           // SUB CATEGORY SELECT INPUT REQUIRED MESSAGE
            'main_cate.exists'      => 'Invalid Category value',                                // SUB CATEGORY SELECT INPUT EXISTS MESSAGE
        ];
    }

}
