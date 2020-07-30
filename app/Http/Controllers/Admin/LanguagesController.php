<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

use function Psy\debug;

class LanguagesController extends Controller
{
    // SHOW TABLE OF ALL WEBSITE LANGUAGES.
    public function index()
    {
        // ALL LANGUAGES FROM DB
        $langs = Language::selection()->paginate(PAGINATION_COUNT);

        // LANGUAGES VIEW.
        return view(
            'admin.languages.index',
            compact('langs')
        );
    }

    // SHOW CREATE LANGUAGE FORM
    public function create()
    {
        // CREATE LANGUAGE FORM
        return view(
            'admin.languages.create'
        );
    }

    // STORE LANGUAGE IN DB AFTER VALIDATION
    public function save(LanguageRequest $request)
    {
        // Language::create($request->except(['_token']));

        try {
            // CREATE NEW LANGUAGE ROW
            Language::create([
                // LANGUAGE TABLE COLUMNS
                'name'      => $request->input('lang-name'),    // LANGUAGE NAME
                'abbr'      => $request->input('lang-abbr'),    // LANGUAGE ABBREVIATION
                'direction' => $request->input('lang-dire'),    // LANGUAGE DIRECTION
                'status'    => $request->input('lang-stat')     // LANGUAGE STATUS
            ]);

            // REDIRECT TO LANGUAGES MAIN TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.languages')->with([
                'success' => 'Stored Successfully'
            ]);

        } catch (\Throwable $th) {
            // REDIRECT TO LANGUAGES MAIN TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.languages')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

    // SHOW EDIT LANGUAGE FORM
    // public function edit($lang_id)
    // {
    //     // DB LANGUAGE OF AN ID
    //     $lang = Language::find($lang_id)->selection();
        

    //     // EDIT LANGUAGE FORM
    //     return view(
    //         'admin.languages.edit',
    //         compact('lang')
    //     );
    // }

}
