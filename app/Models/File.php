<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;

class File extends Model
{
    protected $table = "files";

    protected $fillable = [
        'name',
        'file_path',
        'alt',
        'caption',
        'description',
        'type'
    ];

    protected $appends = [
        'file_path_absolute'
    ];

    public function getFilePathAbsoluteAttribute() {
        $value = $this->file_path;

        if ($value && Storage::exists($this->type . '/' . $value)) {
            if ($this->type === 'public') {
                return url('/storage/' . $value);
            }
        }
        
        return $value;
    }
}
