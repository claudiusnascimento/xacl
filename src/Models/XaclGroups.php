<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XaclGroups extends Model
{

    protected $table = 'xacl_groups';
    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany(app()->make(config('xacl.user_model_path')));
    }

    public function permissions()
    {
        return $this->belongsToMany('XaclPermissions');
    }

    public function actions()
    {
        return $this->belongsToMany('XaclActions');
    }

}
