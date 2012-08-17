<?php

namespace CHH\FileUtils;

# Wrapper around the pathinfo() function, provides also some additional
# path inspecting, like checking if the path is absolute.
class PathInfo
{
    protected
        $originalPath = '',

        # Array returned by pathinfo().
        $pathinfo;

    function __construct($path)
    {
        $this->originalPath = (string) $path;
        $this->pathinfo = pathinfo($path);
    }

    function isAbsolute()
    {
        return Path::isAbs($this->originalPath);
    }

    function getExtension()
    {
        return $this->pathinfo['extension'];
    }

    function getBasename()
    {
        return $this->pathinfo['basename'];
    }

    function getFilename()
    {
        return $this->pathinfo['filename'];
    }

    function getDirname()
    {
        return $this->pathinfo['dirname'];
    }

    function toString()
    {
        return $this->originalPath;
    }

    function __toString()
    {
        return $this->toString();
    }
}

