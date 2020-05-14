<?php

namespace ClaudiusNascimento\XACL\Traits;
use ClaudiusNascimento\XACL\Models\XaclGroup;

trait XaclGroupUserTrait
{

    public function groups() {
        return $this->belongsToMany(XaclGroup::class, 'xacl_group_user', 'user_id', 'group_id');
    }

    public function getGroupChecked($group) {
        return $this->groups->contains('id', $group->id) ? ' checked ' : '';
    }
}
