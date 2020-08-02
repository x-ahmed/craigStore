<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCateRequest;
use App\Models\MainCate;
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

        // STORE THE CATEGORY OF DEGAULT LANGUAGE AND RETURN ITS ID
        $dafaultCateID = MainCate::insertGetID([
            'trans_lang'    => $defaultCate['cate_abbr'],   // CATEGORY LANGUAGE
            'trans_of'      => 0,                           // CATEGORY'S DEFAULT LANGUAGE ID
            'name'          => $defaultCate['cate_name'],   // CATEGORY NAME
            'slug'          => $defaultCate['cate_name'],   // CATEGORY SLUG
            'photo'         => $imgPath,                    // CATEGORY IMAGE PATH
            'status'        => $defaultCate['cate_stat']    // CATEGORY STATUS
        ]);
    }

    public function edit($id)
    {
        return view('admin.main-categories.edit');
    }

}
