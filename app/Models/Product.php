<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['productName','status','product_category_id','price','description'];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productTags()
    {
        return $this->belongsToMany(Tag::class,'product_tags');
    }

    public function productFiles()
    {
        return $this->morphMany(File::class,'fileable');
    }

    public function productZipFiles()
    {
         return $this->morphMany(File::class,'fileable');
    }
}
