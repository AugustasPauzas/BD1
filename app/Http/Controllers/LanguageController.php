<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Language;
use App\Models\Translation;

class LanguageController extends Controller
{
    

    Public function Language ($lang) {
        error_log ("METHOD: Language");


        $language_data = Language::all();




        $language_id = Language::where('language', $lang)->first();


        $translation_data = Translation::where('status', 0)
        ->where('language_id', $language_id->id)
        ->orderBy('id', 'desc')
        ->get();

        return view('language', compact( 'language_data','translation_data', 'lang'));

    }

    Public function Language_update ($lang) {
        error_log ("METHOD: Language");


        $language_data = Language::all();

        $language_id = Language::where('language', $lang)->first();


        $translation_data = Translation::where('status', 1)
        ->where('language_id', $language_id->id)
        ->orderBy('id', 'desc')
        ->get();

        return view('language', compact( 'language_data','translation_data', 'lang'));

    }



    public function update_translation(Request $request, $id)
    {
        error_log("METHOD: update_translation: " . $id);
    
        $validated = $request->validate([
            'translated_text' => 'required|string|max:2000',
        ]);
    
        $translation = Translation::findOrFail($id);
    
        $translation->translated_text = $validated['translated_text'];
        $translation->status = 1;
        $translation->save(); 
    

        return back()->with('success', 'Translation updated successfully!');
    }


}
