<?php
namespace tests;

use BasicLibs\BasicLibs;

class BasicLibs_Test extends \PHPUnit_Framework_TestCase
{
    protected $document;

    protected function setUp()
    {
        $this->document = new \BasicLibs\Document();
    }

    public function testNamespace()
    {
        $this->assertNotNull($this->document);
    }
}
