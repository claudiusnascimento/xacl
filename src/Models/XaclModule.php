<?php

namespace ClaudiusNascimento\XACL\Models;

use Illuminate\Database\Eloquent\Model;

class XaclModule extends Model
{

    protected $table = 'xacl_modules';
    public $timestamps = true;

    protected $fillable = [
        'controller_action'
    ];

    public function groups() {
        return $this->belongsToMany(XaclGroup::class, 'xacl_group_module', 'module_id', 'group_id');
    }

}
