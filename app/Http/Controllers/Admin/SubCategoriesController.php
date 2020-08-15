<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCateRequest;
use App\Models\MainCate;
use App\Models\SubCate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    // SHOW SUB CATEGORIES TABLE VIEW
    public function index()
    {
        try {
            
            // WEBSITE DEFAULT LANGUAGE
            $defLang = getDefaultLang();
            
            // SUB CATEGORIES OF THE DEFAULT LANGUAGE
            $subCates = SubCate::where(
                'trans_lang',
                '=',
                $defLang
            )->selection()->paginate(PAGINATION_COUNT);
            
            // SUB CATEGORIES TABLE VIEW
            return view(
                'admin.sub-categories.index',
                compact('subCates')
            );

        } catch (\Throwable $th) {
            
            // REDIRECT TO ADMIN DASHOBOARD WITH ERROR MESSAGE
            return redirect()->route('admin.dashboard')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }
        
    }

    // SHOW SUB CATEGORY CREATION FORM
    public function create()
    {
        try {

            // ADMIN DEFAULT LANGUAGE
            $defLang = getDefaultLang();

            // DATABASE ACTIVE DEFAULT MAIN CATEGORIES
            $cates = MainCate::where(
                'trans_lang',
                '=',
                $defLang
            )->active()->get();

            // SUB CATEGORY CREATION FORM
            return view(
                'admin.sub-categories.create',
                compact('cates')
            );
            
        } catch (\Throwable $th) {
            
            // REDIRECT TO ADMIN DASHOBOARD WITH ERROR MESSAGE
            return redirect()->route('admin.sub.cates')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }
        
    }

    // STORE SUB CATEGORY CREATION FORM DATA
    public function save(SubCateRequest $request)
    {
        try {
            // CONVERT CATEGORY INPUT BAGS INTO COLLECTION
            $cateBags = collect($request->cate_bags);

            // FILTER THE CATEGORY OF THE DEFAULT LANGUAGE
            $defLangCate = $cateBags->filter(function ($val, $key)
            {
                // WEBSITE DEFAULT LANGUAGE
                $defLang = getDefaultLang();

                // DEFAULT LANGUAGE FILTER KEY
                $key = 'cate_abbr';

                // FILTE THE KEY OF A VALUE
                return $val[$key] == $defLang;
            });

            // CATEGORY OF THE DEFAULT LANGUAGE DETAILS
            $defLangCateDetails = array_values(
                $defLangCate->all()
            )[0];

            // IMAGE REQUEST EXISTANCE CHECK
            if ($request->has('cate_imag')) {

                // UPLOAD IMAGE TO THE SYSTEM FOLDER & GET ITS PATH
                $imgPath = uploadFile(
                    'sub_cates',
                    $request->cate_imag
                );

            } else {

                // MAKE THE PATH EMPTY
                $imgPath = '';
            }

            // START DATABASE TRANSACTIONS
            DB::beginTransaction();

            // INSERT DATA THE CATEGORY OF DEFAULT LANGUAGE
            $defLangCateID = SubCate::insertGetId([
                'trans_lang'    => strtoupper($defLangCateDetails['cate_abbr']),    // CATEGORY TRANSLATION LANGUAGE IN UPPER CASE
                'trans_of'      => 0,                                               // CATEGORY TRANSLATION OF DEFAUTL LANGUAGE CATEGORY ID
                'name'          => ucfirst($defLangCateDetails['cate_name']),       // CATEGORY NAME WITH FIRST LETTER IN UPPER CASE
                'slug'          => $defLangCateDetails['cate_name'],                // CATEGORY SLUG VALUE
                'photo'         => $imgPath,                                        // CATEGORY IMAGE PATH
                'cate_id'       => $request->input('main_cate'),                    // SUB CATEGORY RELATED MAIN CATEGORY
                'status'        => $defLangCateDetails['cate_stat']                 // CATEGORY STATUS
            ]);
            
            // FILTER THE CATEGORY OF OTHER LANGUAGES
            $restLangsCate = $cateBags->filter(function ($val, $key)
            {
                // WEBSITE DEFAULT LANGUAGE
                $defLang = getDefaultLang();

                // DEFAULT LANGUAGE FILTER KEY
                $key = 'cate_abbr';

                // FILTE THE KEY OF A VALUE
                return $val[$key] != $defLang;
            });

            // REST LANGUAGES CATEGORY EXISTANCE CHECK
            if (isset($restLangsCate) && $restLangsCate->count() > 0) {
                
                // REST LANGUAGES CATEGORY EMPTY DATA BOX
                $restLangsCateData = [];

                // REST LANGUAGES CATEGORY LOOP
                foreach ($restLangsCate as $restLangCate) {
                    
                    // FILL UP THE REST LANGUAGES CATEGORY BOX WITH DATA
                    $restLangsCateData[] = [
                        'trans_lang'    => strtoupper($restLangCate['cate_abbr']),      // CATEGORY TRANSLATION LANGUAGE IN UPPER CASE
                        'trans_of'      => $defLangCateID,                              // CATEGORY TRANSLATION OF DEFAUTL LANGUAGE CATEGORY ID
                        'name'          => ucfirst($restLangCate['cate_name']),         // CATEGORY NAME WITH FIRST LETTER IN UPPER CASE
                        'slug'          => $restLangCate['cate_name'],                  // CATEGORY SLUG VALUE
                        'photo'         => $imgPath,                                    // CATEGORY IMAGE PATH
                        'cate_id'       => $request->input('main_cate'),                // SUB CATEGORY RELATED MAIN CATEGORY
                        'status'        => $restLangCate['cate_stat']                   // CATEGORY STATUS
                    ];
                }

                // INSERT THE REST LANGUAGES CATEGORY DATA TO DATABASE
                SubCate::insert($restLangsCateData);
            }

            // COMMIT DATABASE TRANSACTIONS
            DB::commit();

            // REDIRECT TO ADMIN DASHOBOARD WITH SUCCESS MESSAGE
            return redirect()->route('admin.sub.cates')->with([
                'success' => 'Stored Successfully'
            ]);

        } catch (\Throwable $th) {

            // ROLL-BACK THE WHOLE DATABASE TRANSACTIONS
            DB::rollback();
            
            // REDIRECT TO ADMIN DASHOBOARD WITH ERROR MESSAGE
            return redirect()->route('admin.sub.cates')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }
    }

}
