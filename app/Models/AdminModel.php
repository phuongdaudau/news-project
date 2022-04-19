<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    //override constructor in child class
    public function uploadThumb($thumbObj)
    {
        // $thumbObj = move(public_path($this->uploadFolder, $params['thumb']));
        $thumbName  = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->uploadFolder, $thumbName, 'phon_storage_images');
        return $thumbName;
    }
    public function deleteThumb($thumbName)
    {
        Storage::disk('phon_storage_images')->delete($this->uploadFolder . '/' . $thumbName);
    }
    public function prepareItem($params)
    {
        return array_diff_key($params, array_flip($this->NotCrudAccepted));
    }
}
