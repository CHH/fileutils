<?php

namespace CHH\FilePath\Test;

use CHH\FilePath;

class PathnameTest extends \PHPUnit_Framework_TestCase
{
    function setUp()
    {
        return $this->markTestSkipped("TODO: Test isAbsolute");
    }

    /**
     * @dataProvider windowsPathProvider
     */
    function testWindowsPaths($pathname, $expectedResult)
    {
    }

    /**
     * @dataProvider unixPathProvider
     */
    function testUnixPaths($pathname, $expectedResult)
    {
    }

    function windowsPathProvider()
    {
        return array(
            array('C:\\Windows\\System32', true),
            array('/tmp', false),
            array('\\Windows\\System32', true),
            array('\\\\foo\\bar', true)
        );
    }

    function unixPathProvider()
    {
        return array(
            array('/usr/local/bin', true),
            array('C:\\tmp', false),
            array('/', true)
        );
    }
}

