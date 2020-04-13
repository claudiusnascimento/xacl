<?php

namespace ClaudiusNascimento\XACL\Tests;

use Orchestra\Testbench\TestCase;
use ClaudiusNascimento\XACL\XACLServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [XACLServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
