<?php

use Illuminate\Support\Facades\App;
use App\Models\Language;
use App\Models\Translation;


if (!function_exists('translate')) {
    function translate($text)
    {


        $lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'EN'; // Default  'en'

        App::setLocale($lang);

        
        $language = Language::where('language', $lang)->first();
        // If it doesn't exist new entry
        if (!$language) {
            Language::create(['language' => $lang]);
        }



        if ($lang == "EN")
        {
            return __($text);
        }

        if ($lang !== 'EN') {
            $lang_id = $language->id;
    
            // Look for a matching translation
            $translation = Translation::where([
                ['language_id', '=', $lang_id],
                ['original_text', '=', $text],
                ['status', '=', 1],
            ])->first();
    
            // If a translation exists, return it
            if ($translation) {
                return __($translation->translated_text);
            }
    
            $existingTranslation = Translation::where([
                ['language_id', '=', $lang_id],
                ['original_text', '=', $text],
            ])->first();
    
            // If it exists but is inactive (status 0), don't insert again
            if ($existingTranslation && $existingTranslation->status == 0) {
                return __($text);
            }
    
            // If no translation exists, insert a new record with status = 0
            Translation::create([
                'language_id' => $lang_id,
                'original_text' => $text,
                'translated_text' => "",
                'status' => 0,
            ]);
    
            // Return the original text as fallback
            return __($text);
        }

        return __("lang.error");
    }
}
