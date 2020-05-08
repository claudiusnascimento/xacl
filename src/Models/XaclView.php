<?php

namespace ClaudiusNascimento\XACL\Models;

use Illuminate\Database\Eloquent\Model;

class XaclActions extends Model
{

    protected $table = 'xacl_views';
    public $timestamps = true;

    public function groups() {
        return $this->belongsToMany(XaclGroup::class);
    }
}
