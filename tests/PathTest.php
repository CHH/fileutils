<?php

use CHH\FileUtils\Path;

class PathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testIsAbsoluteProvider
     */
    function testIsAbsolute($path, $isAbsolute)
    {
        $this->assertEquals($isAbsolute, Path::isAbsolute($path));
    }

    function testIsAbsoluteProvider()
    {
        return array(
            array("foo/bar", false),
            array("C:\\Windows", true),
            array("C:\\\\Windows", true),
            array("/etc", true),
        );
    }

    function testWithCwd()
    {
        $testCwd = getcwd();
        $dir = realpath('/tmp');

        $cwd = Path::chdir($dir, function() {
            return getcwd();
        });

        $this->assertEquals($testCwd, getcwd(), "Does not influence the CWD outside of the callback");
        $this->assertEquals($dir, $cwd);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testWithCwdThrowsExceptionWhenDirectoryDoesNotExist()
    {
        Path::chdir('/foo', function() {});
    }

    /**
     * @dataProvider testRelativizeProvider
     */
    function testRelativize($expected, $absolute)
    {
        $this->assertEquals($expected, Path::relativize($absolute, __DIR__));
    }

    function testRelativizeProvider()
    {
        return array(
            array('bootstrap.php', realpath(__DIR__.'/bootstrap.php')),
        );
    }
}
