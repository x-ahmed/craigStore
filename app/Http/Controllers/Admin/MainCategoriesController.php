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
        return $request;
    }

    public function edit($id)
    {
        return view('admin.main-categories.edit');
    }

}
