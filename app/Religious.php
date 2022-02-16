<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Religious extends Model
{
    use SoftDeletes;

    public function religiousCast(){
        return $this->hasMany(ReligiousCast::class, 'religious_id');
    }

    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by')->withTrashed();
    }

    public function modifiedBy(){
        return $this->belongsTo(Admin::class, 'modified_by')->withTrashed();
    }
}
