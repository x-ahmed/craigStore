<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function create()
    {
        return view('admin.main-categories.create');
    }

    public function edit($id)
    {
        return view('admin.main-categories.edit');
    }

}
