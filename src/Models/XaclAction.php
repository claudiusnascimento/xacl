<?php

namespace ClaudiusNascimento\XACL\Models;

use Illuminate\Database\Eloquent\Model;

class XaclActions extends Model
{

    protected $table = 'xacl_actions';
    public $timestamps = true;

    protected $fillable = ['action', 'description', 'active', 'options'];

    public function groups() {
        return $this->belongsToMany(XaclGroup::class);
    }
}
