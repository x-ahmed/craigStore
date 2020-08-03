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

            // EMPTY IMAGE PATH STRING
            $imgPath = '';

            // REQUEST IMAGE CHECK
            if ($request->has('cate_imag')) {
                // ASSING IMAGE PATH TO THE PREVIOUS EMPTY VARIABLE
                $imgPath = uploadFile('main-cates', $request->cate_imag);
            }

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
            $cageRestPackets = $catePackets->filter(function ($val, $key)
            {
                // LANGUAGE KEY OF EACH CATEGORY BAG
                $key = 'cate_abbr';
                // ADMIN DEFAULT LANGUAGE
                $defaultLang = getDefaultLang();

                // REST OF CATEGORY BAGS AWAY FROM THE DEFAULT LANGUAGE 
                return $val[$key] != $defaultLang;
            });

            // DEFAULT CATEGORY REST PACKETS EXISTANCE CHECK
            if (isset($cageRestPackets) && $cageRestPackets->count() > 0) {
                
                // DEFAULT CATEGORY REST PACKETS ARRAY
                $catesOfDefaultCate = [];

                // DEFAULT CATEGORY REST PACKETS LOOP
                foreach ($cageRestPackets as $catePacket) {

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

    public function edit($id)
    {
        return view('admin.main-categories.edit');
    }

}
