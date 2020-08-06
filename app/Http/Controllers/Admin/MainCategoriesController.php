<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCateRequest;
use App\Models\MainCate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class MainCategoriesController extends Controller
{
    // SHOW TABLE OF ALL WEBSITE MAIN CATEGORIES.
    public function index()
    {
        try {
            
            // CONFIGURATION DEFAULT LANGUAGE
            $defaultLang = getDefaultLang();

            // COLLECTION OF ALL DB MAIN CATEGORIES
            $mainCates = MainCate::where(
                'trans_lang',
                '=',
                $defaultLang
            )->selection()->paginate(PAGINATION_COUNT);

            // MAIN CATEGORIES TABLE VIEW.
            return view(
                'admin.main-categories.index',
                compact('mainCates')
            );
            
        } catch (\Throwable $th) {
            
            // REDIRECT TO ADMIN DASHOBOARD WITH ERROR MESSAGE
            return redirect()->route('admin.dashboard')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }
        
    }

    // SHOW FORM OF MAIN CATEGORY CREATION
    public function create()
    {
        // MAIN CATEGORY CREATION FORM
        return view('admin.main-categories.create');
    }

    // SAVE MAIN CATEGORY FROM DATA
    public function save(MainCateRequest $request)
    {
        try {

            // CONVERT CATEGORY INPUT BAGS TO COLLECTION.
            $catePackets = collect($request->cate_bags);

            // FILTER DEFAULT LANGUAGE CATEGORY BAG FROM CATEGORY BAGS
            $cateOfDefaultLang = $catePackets->filter(function ($val, $key)
            {
                // LANGUAGE KEY OF EACH CATEGORY BAG
                $key = 'cate_abbr';
                // ADMIN DEFAULT LANGUAGE
                $defaultLang = getDefaultLang();

                // CATEGORY BAG OF THE DEFAULT LANGUAGE 
                return $val[$key] == $defaultLang;
            });

            // DEFAULT LANGUAGE'S CATEGORY BAG AS ARRAY BECAUSE OF [0]
            $defaultCate = array_values(    // REMOVES THE ARRAY KEYS
                $cateOfDefaultLang->all()   // CONVERTS OBJECT TO ARRAY
            )[0];                           // TO RETURN THE ARRAY FIRST OBJECT WHICH IS THE ONLY EXIST ONE AS AN ARRAY

            // EMPTY IMAGE PATH STRING
            $imgPath = '';

            // REQUEST IMAGE CHECK
            if ($request->has('cate_imag')) {
                // DEFAULT CATEGORY BAG'S EMPTY CHECK
                if (!empty($cateOfDefaultLang)) {
                    // ASSING IMAGE PATH TO THE PREVIOUS EMPTY VARIABLE
                    $imgPath = uploadFile('main_cates', $request->cate_imag);
                }
            }

            // START DATABASE STATEMENTS TRANSACTIONS
            DB::beginTransaction();

            // STORE THE CATEGORY OF DEGAULT LANGUAGE AND RETURN ITS ID
            $defaultCateID = MainCate::insertGetId([
                'trans_lang'    => strtoupper($defaultCate['cate_abbr']),   // CATEGORY LANGUAGE
                'trans_of'      => 0,                                       // CATEGORY'S DEFAULT LANGUAGE ID
                'name'          => ucfirst($defaultCate['cate_name']),      // CATEGORY NAME
                'slug'          => $defaultCate['cate_name'],               // CATEGORY SLUG
                'photo'         => $imgPath,                                // CATEGORY IMAGE PATH
                'status'        => $defaultCate['cate_stat']                // CATEGORY STATUS
            ]);

            // FILTER REST OF CATEGORY BAGS 
            $cateRestPackets = $catePackets->filter(function ($val, $key)
            {
                // LANGUAGE KEY OF EACH CATEGORY BAG
                $key = 'cate_abbr';
                // ADMIN DEFAULT LANGUAGE
                $defaultLang = getDefaultLang();

                // REST OF CATEGORY BAGS AWAY FROM THE DEFAULT LANGUAGE 
                return $val[$key] != $defaultLang;
            });

            // DEFAULT CATEGORY REST PACKETS EXISTANCE CHECK
            if (isset($cateRestPackets) && $cateRestPackets->count() > 0) {
                
                // DEFAULT CATEGORY REST PACKETS ARRAY
                $catesOfDefaultCate = [];

                // DEFAULT CATEGORY REST PACKETS LOOP
                foreach ($cateRestPackets as $catePacket) {

                    // DEFAULT CATERGORY REST PACKETS INPUT DATA
                    $catesOfDefaultCate[] =[
                        'trans_lang'    => strtoupper($catePacket['cate_abbr']),    // CATEGORY LANGUAGE
                        'trans_of'      => $defaultCateID,                          // CATEGORY'S LANGUAGE ID
                        'name'          => ucfirst($catePacket['cate_name']),       // CATEGORY NAME
                        'slug'          => $catePacket['cate_name'],                // CATEGORY SLUG
                        'photo'         => $imgPath,                                // CATEGORY IMAGE PATH
                        'status'        => $catePacket['cate_stat']                 // CATEGORY STATUS
                    ];
                }

                // STORE REST PACKETS RELATED TO THE DEFAULT CATEGORY IN DB
                $siblings = MainCate::insert($catesOfDefaultCate);

                // // STORING CHECK
                // if ($defaultCateID && $siblings) {
                //     // REDIRECT TO MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
                //     return redirect()->route('admin.main.cates')->with([
                //         'success' => 'Stored Successfully'
                //     ]);
                // }
            }

            // COMMIT DATABASE STATEMENTS TRANSACTIONS
            DB::commit();

            // REDIRECT TO MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'success' => 'Stored Successfully'
            ]);

        } catch (\Throwable $th) {

            // CHECK ERRORS AND IF EXIST DON'T IMPLEMENT ANY OF THE PREVIOUS TRANSACTIONS
            DB::rollBack();

            // REDIRECT TO MAIN CATEGORY CREATION FORM WITH ERROR MESSAGE
            return redirect()->route('admin.main.cate.create')->with([
                'error' => 'something went terribly wrong'
            ]);
        }

    }

    // SHOW FORM OF EDITING MAIN CATEGORY'S VIEW
    public function edit($cate_id)
    {
        try {
            
            // DATABASE MAIN CATEGORY WITH ITS TRANSLATIONS
            $cate = MainCate::with(['trans_cates'])->selection()->find($cate_id);

            // MAIN CATEGORY DB EXISTANCE CHECK
            if (!$cate) {
                return redirect()->route('admin.main.cates')->with([
                    'error' => 'No such main category'
                ]);
            }
            
            // REDIRECT TO EDITING FORM VIEW
            return view(
                'admin.main-categories.edit',
                compact('cate')
            );
            
        } catch (\Throwable $th) {
            
            // REDIRECT TO ADMIN MAIN CATEGORITES TABLE
            return redirect()->route('admin.main.cates')-with([
                'error' => 'Something went terribly wrong'
            ]);
        }
        
    }

    // UPDATE MAIN CATEGORY EDIT FROM DATA
    public function update(MainCateRequest $request, $cate_id)
    {
        try {

            // DB MAIN CATEGORY OF AN ID TO BE EDITED
            $cate = MainCate::find($cate_id);

            // DB MAIN CATEGORY EXISTANCE CHECK
            if (!$cate) {

                // REDIRECT TO MAIN CATEGORIES TABLE WITH ERRO MESSAGE
                return redirect()->route('admin.main.cates')->with([
                    'error' => 'No such main category'
                ]);
            }

            // CONVERT THE REQUEST DATA TO AN ARRAY AND ONLY RETRIEVE THE ONE ALREADY EXIST 
            $cateInputVals = array_values(      // ARRAY CONVERSION
                $request->input('cate_bags')    // CATEGORY ARRAY OF THE REQUEST OBJECT
            )[0];                               // CATEGORY ARRAY RETRIEVEMENT

            // CATEGORY NOT ACTIVE CHECK (STATUS NOT CHECK SO IT MUST EQUAL ZERO)
            if (
                !array_key_exists(      // CHECK FOR ARRAY KEY NAME
                    'cate_stat',        // STATUS KEY NAME
                    $cateInputVals      // ARRAY TO LOOK
                )
            ) {
                // ADD STATUS VALUE OF ZERO TO THE ARRAY
                $cateStatus = array_merge(      // METHOD TO ADD NEW KEY & VALUE TO AN EXISTANCE ARRAY
                    $cateInputVals,             // ARRAY TO ADD
                    [
                        'cate_status' => 0      // KAY AND VALUE TO BE ADDED
                    ]
                )['cate_status'];               // VALUE ADDED RETRIEVEMENT
            } else {
                
                // CONVERT THE ALREADY EXIST ACTIVE VALUE FROM A STRING TO AN INTEGER
                $cateStatus = intval(               // CONVERSION METHOD
                    $cateInputVals['cate_stat']     // VALUE EXIST RETRIEVEMENT
                );
            }

            // UPDATE STATEMENT OF NEW VALUE TO DATABASE 
            $cate->update([
                'name'          => ucfirst($cateInputVals['cate_name']),        // CATEGORY NAME
                'trans_lang'    => strtoupper($cateInputVals['cate_abbr']),     // CATEGORY TRANSLATION LANG
                'status'        => $cateStatus                                  // CATEGORY STATUS
            ]);

            // REQUEST DATA HAS IMAGE CHECK
            if ($request->has('cate_imag')) {
                // REST INPUTS ARRAY NOT EMPTY CHECK
                if (!empty($cateInputVals)) {
                    
                    // UPLOAD CATEGORY IMAGE TO ITS FOLDRER AND RETURN ITS PATH
                    $imgPath = uploadFile('main_cates', $request->cate_imag);

                    // UPDATE STATEMENT OF NEW IMAGE TO DATABASE
                    $cate->update([
                        'photo' => $imgPath     // CATEGORY IMAGE
                    ]);
                }
            }

            // REDIRECT TO ADMIN MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'success' => 'Updated Successfully'
            ]);
            
        } catch (\Throwable $th) {
            
            // REDIRECT TO ADMIN MAIN CATEGORIES TABLE ERROR MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

}
