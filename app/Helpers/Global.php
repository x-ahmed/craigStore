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
