<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable=['fileable_id','fileable_type','file','fileType'];

    protected $appends=['imagePath'];

    public function fileable()
    {
    	return $this->morphTo();
    }

    public function getimagePathAttribute()
    {
        return asset('/product-files/')."/".$this->file;
    }
}
