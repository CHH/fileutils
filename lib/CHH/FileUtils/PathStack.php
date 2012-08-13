<?php

namespace CHH\FileUtils;

class PathStack extends \SplStack
{
    function __construct($loadPaths = array())
    {
        if ($loadPaths) {
            $this->push($loadPaths);
        }
    }

    function push($paths)
    {
        $paths = (array) $paths;

        foreach ($paths as $path) {
            $this->validate($path);
            parent::push(rtrim($path, '\/'));
        }

        return $this;
    }

    function unshift($paths)
    {
        $paths = (array) $paths;

        foreach ($paths as $path) {
            $this->validate($path);
            parent::unshift(rtrim($path, '\/'));
        }

        return $this;
    }

    function find($file)
    {
        foreach ($this as $loadPath) {
            $filePath = $loadPath.DIRECTORY_SEPARATOR.$file;

            if (file_exists($filePath)) {
                return $filePath;
            }
        }
        return false;
    }

    function __toString()
    {
        return join(':', iterator_to_array($this));
    }

    function toArray()
    {
        return iterator_to_array($this);
    }

    protected function validate($value)
    {
        if (!is_dir($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Path %s is not a valid directory', $value
            ));
        }
        return $value;
    }
}

