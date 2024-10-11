<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Specification;
use App\Models\ImageParse;


class FunctionController extends Controller
{
    public function language_parse($input_text)
    {   
        //TODO create language translator
        error_log( 'Parsing Text: '.$input_text);
        //$this->language_parse("test");
        $translater_text= "translated";
        return $translater_text;
    }

    public function remove_dublication_from_specification()
    {
        error_log('METHOD remove_dublication_from_specification');
        $data_specification = Specification::all();
        $uniqueSpecifications = [];
        foreach ($data_specification as $specification) {
            $key = $specification->item_id . '_' . $specification->value_id . '_' . $specification->parameter_id;
            if (isset($uniqueSpecifications[$key])) {
                //error_log('Deleting duplicate: ' . json_encode($specification));
                $specification->delete(); 
            } else {
                $uniqueSpecifications[$key] = $specification->id;
            }
        }
        return response()->json(['message' => 'Duplicate specifications removed successfully.']);
    }

    public function item_images_reorder()
    {
        
        $uniqueItemIds = ImageParse::distinct()->pluck('item_id');
        foreach ($uniqueItemIds as $uniqueItemId) {
            $images = ImageParse::where('item_id', $uniqueItemId)->orderBy('position')->get();
            $new_position = 1;
            foreach ($images as $img) {
                $update_target = ImageParse::find($img->id);
                if ($update_target->position !== $new_position) {
                    $update_target->position = $new_position;
                    $update_target->save();
                }
                $new_position++;
            }
        }
        //return response()->json(['status' => 'success', 'message' => 'Image positions reordered successfully.']);
        return;
    }
}
