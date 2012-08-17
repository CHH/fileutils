<?php

namespace CHH\FileUtils\Test;

use CHH\FileUtils\PathStack;

class PathstackTest extends \PHPUnit_Framework_TestCase
{
    protected $stack;

    function setUp()
    {
        $this->stack = new PathStack;
    }

    /**
     * @dataProvider findDataProvider
     */
    function testFind($paths, $extensions, $file, $expected)
    {
        $stack = new PathStack();
        $stack->appendPaths($paths);
        $stack->appendExtensions($extensions);

        $this->assertEquals($expected, $stack->find($file));
    }

    function findDataProvider()
    {
        return array(
            array(
                explode(':', $_SERVER["PATH"]), null, 'ls', '/bin/ls'
            ),
            array(
                array(__DIR__ . "/fixtures/path1", __DIR__ . "/fixtures/path2"),
                ".php",
                "foo",
                __DIR__ . "/fixtures/path2/foo.php"
            )
        );
    }

    function testPushPathArray()
    {
        $this->stack->push(array(__DIR__, dirname(__DIR__)));

        $this->assertEquals(
            array(__DIR__, dirname(__DIR__)),
            $this->stack->toArray()
        );
    }

    function testUnshiftPathArray()
    {
        $this->stack->unshift(array(__DIR__, dirname(__DIR__)));

        $this->assertEquals(
            array(dirname(__DIR__), __DIR__),
            $this->stack->toArray()
        );
    }
}

