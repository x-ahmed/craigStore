<?php

use App\Models\Language;
use Illuminate\Support\Facades\Config;

/*
    ** HELPER FUNCTION THAT SELECTS LANGUAGES
    ** (id, name, abb, direction, status)
    ** WHERE (status = 1)
    */
    function getActiveLangs()
    {
        // PRE-DEFINED LANGUAGE MODEL'S SCOPES
        return Language::active()->selection()->get();
    }
    
    /*
    ** HELPER FUNCTION THAT GETS DEFAULT LANGUAGE
    */
    function getDefaultLang()
    {
        // CONFIGURATION DEFAULT LANGUAGE FROM "config\app.php"
        // return Config::get('app.locale');    // RETURNS DEFAULT LANGUAGE "en"
        return Config::get('locale', 'ar');     // OVERRIDES DEFAULT LANGUAGE TO "ar"
    }

    /*
    ** HELPER FUNCTION THAT
    ** UPLOADS FILE
    ** PARAMS:
    **  - FIRST PARAM IS FOLDER NAME
    **  - SECOND PARAM IS FILE NAME
    ** ----------------------------
    ** NOTE THAT MAIN CATEGORIES METHOD
    ** IS PREDEFINED INTO "config\filesystems.php"
    */

    function uploadFile($folder, $file)
    {
        $file->store('/', $folder);                     // STORE FILE INTO A FOLDER
        $fileName = $file->hashName();                  // HASH THE FILE NAME
        $path = 'images/' .$folder. '/' .$fileName;     // FILE PATH TO SAVE

        return $path;
    }
