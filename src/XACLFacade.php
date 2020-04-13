<?php

namespace ClaudiusNascimento\XACL;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ClaudiusNascimento\XACL\Skeleton\SkeletonClass
 */
class XACLFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xacl';
    }
}
