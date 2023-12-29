<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminModel extends Model {
    // use HasFactory;
    public $timestamps = false; // if not set, the default is true
    protected $table                = '';
    protected $folderUpload         = '';
    const CREATED_AT                = 'created';
    const UPDATED_AT                = 'modified';
    protected $fieldSearchAccepted  = ['id', 'name'];
    protected $crudNotAccepted      = ['_token', 'thumb_current'];

    public function deleteThumb($thumbName) {
        Storage::disk('storage_image')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function uploadThumb($thumbObj) {
        $thumbName          = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'storage_image');

        return $thumbName;
    }

    public function prepareParams($arrParam) {
        return array_diff_key($arrParam, array_flip($this->crudNotAccepted));
    }
}
