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
        'active',
        'order'
    ];

    public function users()
    {
        $userClass = config('xacl.user_model.path', 'App\Models\User');

        return $this->belongsToMany($userClass, 'xacl_group_user', 'group_id', 'user_id');
    }

    public function modules()
    {
        return $this->belongsToMany(XaclModule::class, 'xacl_group_module', 'group_id', 'module_id');
    }

    public function actions()
    {
        return $this->belongsToMany(XaclAction::class, 'xacl_action_group', 'group_id', 'action_id');
    }

}
