<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCate;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
    //
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
}
