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

        // LANGUAGES MAIN TABLE VIEW.
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

    // STORE A LANGUAGE IN DB AFTER VALIDATION
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

            // REDIRECT TO LANGUAGES MAIN TABLE VIEW WITH SUCCESS MESSAGE
            return redirect()->route('admin.languages')->with([
                'success' => 'Stored Successfully'
            ]);

        } catch (\Throwable $th) {
            // REDIRECT TO LANGUAGES MAIN TABLE VIEW WITH ERROR MESSAGE
            return redirect()->route('admin.languages')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

    // SHOW EDIT A LANGUAGE FORM
    public function edit($lang_id)
    {
        
        // DB LANGUAGE OF AN ID
        $lang = Language::selection()->find($lang_id);

        // DB LANGUAGE NOT EXIST CHECK
        if (!$lang) {
            // REDIRECT TO LANGUAGES MAIN TABLE VIEW WITH ERROR MESSAGE
            return redirect()->route('admin.languages')->with([
                'error' => 'No such language'
            ]);
        }
        
        // EDIT LANGUAGE FORM
        return view(
            'admin.languages.edit',
            compact('lang')     // LANGUAGE OBJECT
        );
    }

    // UPDATE A LANGUAGE IN DB
    public function update(LanguageRequest $request, $lang_id)
    {

        try {

            // DB LANGUAGE OF AN ID
            $lang = Language::find($lang_id);

            // DB LANGUAGE NOT EXIST CHECK
            if (!$lang) {
                // REDIRECT TO LANGUAGES MAIN TABLE VIEW WITH ERROR MESSAGE
                return redirect()->route('admin.language.edit', $lang_id)->with([
                    'error' => 'No such language'
                ]);
            }

            // if (!$request->has('lang-stat')) {
            //     $langStatus = $request->request/*()*/->add([
            //         'status' => 0
            //     ]);
            // } else {
            //     $langStatus = $request->input('lang-stat');
            // }
            

            // UPDATE A LANGUAGE ROW
            $lang->update([
                'name'      => $request->input('lang-name'),    // LANGUAGE NAME
                'abbr'      => $request->input('lang-abbr'),    // LANGUAGE ABBREVIATION
                'direction' => $request->input('lang-dire'),    // LANGUAGE DIRECTION
                'status'    => $request->input('lang-stat')    // LANGUAGE STATUS
            ]);

            // REDIRECT TO THE LANGUAGES MAIN TABLE VIEW WITH A SUCCESS MESSAGE
            return redirect()->route('admin.languages')->with([
                'success' => 'Updated Successfully'
            ]);

        } catch (\Throwable $th) {

            // REDIRECT TO LANGUAGES MAIN TABLE VIEW WITH ERROR MESSAGE
            return redirect()->route('admin.languages')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

    // DELETE A LANGUAGE FROM DB
    public function destroy($lang_id)
    {

        try {
            // DB LANGUAGE OF AN ID
            $lang = Language::find($lang_id);

            // DB LANGUAGE NOT EXIST CHECK
            if (!$lang) {

                // REDIRECT TO LANGUAGES MAIN TABLE VIEW WITH ERROR MESSAGE
                return redirect()->route('admin.languages')->with([
                    'error' => 'No such language'
                ]);
            }
    
            // DELETE A LANGUAGE ROW
            $lang->delete();
    
            // REDIRECT TO THE LANGUAGES MAIN TABLE VIEW WITH SUCCESS MESSAGE
            return redirect()->route('admin.languages')->with([
                'success' => 'Deleted Successfully'
            ]);

        } catch (\Throwable $th) {

            // RETURN TO THE LANGUAGES MAIN TABLE VIEW WITH ERROR MESSAGE
            return redirect()->route('admin.languages')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

}
