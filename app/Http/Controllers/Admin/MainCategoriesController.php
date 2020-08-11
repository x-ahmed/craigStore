<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCateRequest;
use App\Models\MainCate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
// use Illuminate\Support\Arr;
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

    // UPDATE MAIN CATEGORY EDIT FORM DATA
    public function update(MainCateRequest $request, $cate_id)
    {
        
        try {

            // FIND MAIN CATEGORY OF THE DEFAULT LANGUAGE
            $cate = MainCate::find($cate_id);

            // CHECK MAIN CATEGORY NOT EXIST IN DATABASE
            if (!$cate) {

                // REDIRECT TO MAIN CATEGORY TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.main.cate.edit')->with([
                    'error' => 'No such main category'
                ]);
            }
            
            // START DATABASE STATEMENTS TRANSACTIONS
            DB::beginTransaction();

            // NEW IMAGE UPLOADED CHECK
            if ($request->has('cate_imag')) {
                
                // CHECK MAIN CATEGORY EXISTANCE IN DATABASE
                if ($cate) {
                    
                    // DELETE THE OLD MAIN CATEGORY IMAGE FROM SERVER FOLDER
                    deleteFile($cate->photo);
                }

                // NEW UPLOADED TO SERVER MAIN CATEGORY IMAGE PATH TO BE STORED IN DATABASE
                $imgPath = uploadFile(
                    'main_cates',           // SERVER FOLDER WHERE TO UPLOAD
                    $request->cate_imag     // FILE NAME WHICH TO STORE
                );

                // DATABASE UPDATE NEW IMAGE STATEMENT
                $cate->update([
                    'photo' => $imgPath
                ]);

            }

            // MAIN CATEGORY ARRAY OF INPUT DATA FOR THE DEFAULT LANGUAGE
            $defLangCate =  array_values(
                $request->cate_bags
            )[0];

            // MERGE THE TRANSLATION LANGUAGE VALUE OF ZERO AS IT IS THE DEFAULT LANGUAGE
            $defCateTrans = array_merge(
                $defLangCate,           // MAIN CATEGORY ARRAY OF INPUT DATA FOR THE DEFAULT LANGUAGE
                [
                    'cate_trans' => 0   // KEY AND VALUE TO BE ADDED TO THE DEFAULT MAIN CATEGORY ARRAY DATE
                ]
            )['cate_trans'];            // RETRIEVE THE MERGED VALUE OF TRANSLATION LANGUAGE KEY

            // CHECK DEFAULT MAIN CATEGORY IS EDITED TO BE DEACTIVATED
            if (!array_key_exists('cate_stat', $defLangCate)) {
                
                $defCateStat = array_merge(     // APPEND THE VALUE OF ZERO FOR DEACTIVATION
                    $defLangCate,               // MAIN CATEGORY ARRAY OF INPUT DATA FOR THE DEFAULT LANGUAGE
                    [
                        'cate_stat' => 0        // KEY AND VALUE OF DEACTIVATION TO BE MERGED TO THE ARRAY
                    ]
                )['cate_stat'];                 // RETRIEVEMENT OF THE THE MERGED DEFAULT MAIN CATEGORY STATUS
            } else {

                $defCateStat = intval(          // CONVERT THE VALUE OF ACTIVATION FROM STRING AS INSERTED TO INTEGER
                    $defLangCate['cate_stat']   // DEFAULT MAIN CATEGORY ACTIVATION INITIALLY INSERTED VALUE
                );
            }

            // DEFAULT LANGUAGE MAIN CATEGORY UPDATE STATEMENT
            $cate->update([
                    'name'          => ucfirst($defLangCate['cate_name']),      // DEFAULT MAIN CATEGORY NAME STARTED WITH UPPER CASE LETTER
                    'trans_lang'    => strtoupper($defLangCate['cate_abbr']),   // DEFAULT MAIN CATEGORY ABBREVIATION OF TRANSLATION LANGUAGE IN UPPDER CASE
                    'trans_of'      => $defCateTrans,                           // DEFAULT MAIN CATEGORY TRANSLATION LANGUAGE WHICH IS BASICALLY ZERO
                    'status'        => $defCateStat                             // DEFAULT MAIN CATEGORY STATUS VALUE ZERO OR ONE
                ]);
    
            ###################################################
            
            // ARRAY OF ALL DEFAULT AND TRANSLATED CATEGORIES
            $cateInDiffLangs =  array_values(
                $request->cate_bags
            );
            
            // CHECK ALL DEFAULT AND TRANSLATED CATEGORIES
            if (isset($cateInDiffLangs) && count($cateInDiffLangs) > 0) {
    
                // CHECK DEFAULT CATEGORY EXISTS IN GENERAL ARRAY
                if (array_key_exists(0, $cateInDiffLangs)) {

                    // REMOVE THE DEFAULT CATEGORY
                    unset($cateInDiffLangs[0]);
                }
                
                // CHECK ALL TRANSLATED CATEGORIES
                if (isset($cateInDiffLangs) && count($cateInDiffLangs) > 0) {

                    // TRANSLATED CATEGORIES LOOP
                    foreach ($cateInDiffLangs as $cateInOneLang) {
                        
                        // CHECK IF THE TRANSLATED CATEGORY IS DEACTIVATED
                        if (!array_key_exists('cate_stat', $cateInOneLang)) {

                            $cateStat = array_merge(    // MERGE DEACTIVATION VALUE TO THE TRANSLATED CATEGORY ARRAY
                                $cateInOneLang,         // TRANSLATED CATEGORY ARRAY WHERE TO MERGE
                                [
                                    'cate_stat' => 0    // DEACTIVATION KAY AND VALUE TO BE MERGED
                                ]
                            )['cate_stat'];             // RETRIEVEMENT OF THE DEACTIVATION VALUE ADDED
                        } else {

                            $cateStat = intval(                 // CONVERT THE DEFAULT INSERTED ACTIVATION VALUE FROM A STRING TO INTEGER
                                $cateInOneLang['cate_stat']     // THE DEFAULT INSERTED ACTIVATION STRING VALUE
                            );
                        }

                        // ARRAY OF TRANSLATED CATEGORY DATA TO BE ADDED
                        $cateTranslations[] = [
                            'id'            => intval($cateInOneLang['cate_id']),               // TRANSLATED CATEGORY ID AS INTEGER VALUE
                            'name'          => ucfirst($cateInOneLang['cate_name']),            // TRANSLATED CATEGORY NAME WITH FIRST LETTER IN UPPER CASE
                            'trans_lang'    => strtoupper($cateInOneLang['cate_abbr']),         // TRANSLATED CATEGORY LANGUAGE OF TRANSLATION IN UPPER CASE
                            'trans_of'      => intval($cateInOneLang['cate_trans']),            // TRANSLATED CATEGORY LANGUAGE OF TRANSLATION AS INTEGER
                            'status'        => $cateStat                                        // TRANSLATED CATEGORY STATUS WHETHER ACTIVE OR NOT
                        ];
        
                    }

                }
                
            }
            
            // CHECK WHETHER ARRAY OF TRANSLATED CATEGORY DATA EXISTS AND  EMPTY 
            if (isset($cateTranslations) && count($cateTranslations) > 0) {

                // TRANSLATED CATEGORY DATA LOOP
                foreach ($cateTranslations as $cateTranslation) {
                    
                    // DATABASE TRANSLATED CATEGORY OF AN ID
                    $cateTranslationID = MainCate::find($cateTranslation['id']);

                    // NEW IMAGE UPLOADED CHECK
                    if ($request->has('cate_imag')) {

                        // DATABASE TRANSLATED CATEGORY EXISTANCE CHECK
                        if ($cateTranslationID) {

                            // DELETE THE OLD TRANSLATED CATEGORY IMAGE FROM SERVER
                            deleteFile($cateTranslationID->photo);
                        }

                        // UPLOAD THE NEW CATEGORY IMAGE TO ITS FOLDER ON SERVER
                        $imgPath = uploadFile('main_cates', $request->cate_imag);

                        // DATABASE UPDATE TRANSLATED CATEGORY IMAGE STATEMENT
                        $cateTranslationID->update([
                            'photo' => $imgPath
                        ]);

                    }

                    // DATABASE UPDATE THE TRANSLATED CATEGORY DATA STATEMENT
                    $cateTranslationID->update([
                        'name'          => $cateTranslation['name'],            // TRANSLATED CATEGORY NAME
                        'trans_lang'    => $cateTranslation['trans_lang'],      // TRANSLATED CATEGORY TRANSLATION LANGUAGE
                        'trans_of'      => $cateTranslation['trans_of'],        // TRANSLATED CATEGORY DEFAULT LANGUAGE OF TRANSLATION
                        'status'        => $cateTranslation['status']           // TRANSLATED CATEGORU STATUS WHETHE ACTIVE OR NOT
                    ]);
        
                }

            }
            
            // COMMIT DATABASE STATEMENTS TRANSACTIONS
            DB::commit();

            // REDIRECT TO MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'success' => 'Updated Successfully'
            ]);
    

        } catch (\Throwable $th) {
            
            // CHECK ERRORS AND IF EXIST DON'T IMPLEMENT ANY OF THE PREVIOUS TRANSACTIONS
            DB::rollBack();

            // REDIRECT TO MAIN CATEGORY EDIT FORM WITH ERROR MESSAGE
            return redirect()->route('admin.main.cate.edit')->with([
                'error' => 'something went terribly wrong'
            ]);

        }
        
    }

    // DELETE A MAIN CATEGORY FROM DATABASE
    public function destroy($mainCateID)
    {
        
        try {

            // DATABASE MAIN CATEGORY ROW
            $mainCate = MainCate::find($mainCateID);
            
            // DATABASE MAIN CATEGORY NOT EXIST CHECK
            if (!$mainCate) {
                
                // REDIRECT TO MAIN CATEGORIES TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.main.cates')->with([
                    'error' => 'No such main category'
                ]);
            }

            // MAIN CATEGORY'S VENDORS
            $vends = $mainCate->vendors();

            // MAIN CATEGORY HAS VENDORS CHECK
            if (isset($vends) && $vends->count() > 0) {
                
                // REDIRECT TO MAIN CATEGORIES TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.main.cates')->with([
                    'error' => 'It\'s not allowed to delete this main category'
                ]);
            }

            // DELETE MAIN CATEGORY IMAGE FROM SERVER
            deleteFile($mainCate->photo);

            // DATABASE MAIN CATEGORY DELETE STATEMENT
            $mainCate->delete();

            // REDIRECT TO MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'success' => 'Deleted Successfully'
            ]);

        } catch (\Throwable $th) {
            
            // REDIRECT TO MAIN CATEGORIES TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'error' => 'Something went terribly wrong'
            ]);

        }

    }

    // CHANGE MAIN CATEGORY STATUS
    public function changeStatus($mainCateID)
    {
        // try {
            
        // } catch (\Throwable $th) {
            
        //     return redirect()->route('admin.main.cates')->with([
        //         'error' => 'Something went terribly wrong'
        //     ]);
        // }

        // DATABASE MAIN CATEGORY OF AN ID
        $mainCate = MainCate::find($mainCateID);

        // DATABASE MAIN CATEGORY EXISTANCE CHECK
        if (!$mainCate) {
            
            // REDIRECT TO MAIN CATEGORIES TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.main.cates')->with([
                'error' => 'No such main category'
            ]);
        }

        // CHANGE STATUS FROM ZERO TO ONE OR FROM ONE TO ZERO
        $mainCateStat = ($mainCate->status === 0)? 1: 0;

        // DATABASE MAIN CATEGORY STATUS UPDATE STATEMENT
        $mainCate->update([
            'status' => $mainCateStat
        ]);

        // REDIRCT TO MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
        return redirect()->route('admin.main.cates')->with([
            'success' => 'Stutus changed successfully'
        ]);
    }

}
