<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    // SHOW ALL WEBSITE LANGUAGES.
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
}
