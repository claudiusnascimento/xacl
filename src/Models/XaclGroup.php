<?php

namespace ClaudiusNascimento\XACL\Models;

use Illuminate\Database\Eloquent\Model;

class XaclGroup extends Model
{

    protected $table = 'xacl_groups';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'options',
        'active'
    ];

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
