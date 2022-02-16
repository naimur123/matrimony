<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by')->withTrashed();
    }

    public function modifiedBy(){
        return $this->belongsTo(Admin::class, 'modified_by')->withTrashed();
    }

    public function blogCategory(){
        return $this->belongsTo(BlogCatrgory::class, 'blog_category_id')->withTrashed();
    }
}
