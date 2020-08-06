<?php

use App\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File; 

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
        return Config::get(
            'locale',               // OVERRIDES DEFAULT LANGUAGE TO "ar"
            strtoupper('ar')        // CONVERT LANGUAGE ABBREVIATION TO UPPER CASE
        );
    }

    /*
    ** HELPER FUNCTION THAT
    ** RETURNS THE LANGUAGE NAME
    ** BASED ON THE DATABASE ABBREVIATION
    ** PARAMS:
    **  - PARAM IS DB ABBREVIATION VALUE
    */

    function getLanguageName($val)
    {
        // CHECK VALUE IS ARABIC
        if ($val == 'AR') {
            return 'العربيه';
        }
        // CHECK VALUE IS ENGLISH
        else if ($val == 'EN') {
            return 'English';
        }
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

    /*
    ** HELPER FUNCTION THAT
    ** DELETES FILE
    ** PARAMS:
    **  - FIRST PARAM IS FILE URL FROM DATABASE
    */

    function deleteFile($fileURL)
    {
        $pathURL = implode(     // GLUE THE SLICED ARRAY BY "/" SEPARATOR TO BE A STRING OF FILE PATH
            '/',                // THE GLUE SEPARATOR
            array_slice(        // SLICE A NEW ARRAY OF THE LAST FOUR ELEMENTS WHICH REPRESENTS THE FILE PATH AFTER THE PROJECT BASE FILE
                explode(        // CONVERT THE FILE PATH TO ARRAY SPLITTED BY "/"
                    '/',        // SPLITTER
                    parse_url($fileURL)['path']     // PARSE URL PATH TO GET RED OF "http://localhost"
                ),
                -4,             // THE RIGHT POSITION TO START FROM 
                4               // NUMBER OF ELEMENTS TO BE SLICED
            )
        );
        $fileServerPath = str_replace(
            '\\',               // REPLACE THE BASE FOLER PATH LINUX SEPARATOR "\"
            '/',                // WITH "/" 
            base_path()         // THE PROJECT/SERVER BASE FOLDER
        ). '/' .$pathURL;       // APPEND THE FOLDER BASE PATH WITH THE DESIRED FILE URL

        // FILE EXISTANCE CHECK IN SERVER PATH
        if (File::exists($fileServerPath))
        {
            // DELETE THE DESIRED FILE
            File::delete($fileServerPath);
        }

    }
