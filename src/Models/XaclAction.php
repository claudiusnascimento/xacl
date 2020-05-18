<?php

namespace ClaudiusNascimento\XACL\Models;

use Illuminate\Database\Eloquent\Model;

class XaclAction extends Model
{

    protected $table = 'xacl_actions';
    public $timestamps = true;

    public $appends = ['name'];

    protected $fillable = ['action', 'description', 'active', 'options'];

    public function getNameAttribute() {
        return $this->action;
    }

    public function groups() {
        return $this->belongsToMany(XaclGroup::class, 'xacl_action_group', 'action_id', 'group_id');
    }
}
