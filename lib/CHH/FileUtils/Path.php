<?php

namespace CHH\FileUtils;

class Path
{
    # Public: Checks if the given path is absolute, regardless
    # if the file exists or not.
    #
    # path - Path to check if absolute.
    #
    # Returns a Boolean.
    static function isAbsolute($path)
    {
        if (realpath($path) === $path) {
            return true;
        }

        if (empty($path)) {
            return false;
        }

        # Absolute Path (Unix) or Absolute UNC Path.
        if ($path[0] === '/' or $path[0] === '\\') {
            return true;
        }

        # If the path starts with a drive letter or "\\" (Windows):
        if (static::isWindows() and preg_match('#^([a-z]\:)?\\\\{1,2}#i', $path)) {
            return true;
        }
        return false;
    }

    static function isAbs($path)
    {
        return static::isAbsolute($path);
    }

    static protected function isWindows()
    {
        return "WIN" == strtoupper(substr(PHP_OS, 0, 3));
    }

    # Public: Joins path elements with a operating system specific separator.
    #
    # parts - Array of path elements.
    #
    # TODO:
    #  - Clean up double slashes
    #
    # Returns the joined path elements as String.
    static function join($parts)
    {
        if ($parts instanceof \Iterator) {
            $parts = iterator_to_array($parts);
        }

        return join(DIRECTORY_SEPARATOR, $parts);
    }

    static function normalizeExtension($extension)
    {
        $extension = strtolower($extension);

        if ('.' != $extension[0]) {
            $extension = ".$extension";
        }
        return $extension;
    }

    # Public: Checks if the dest file is not older than the
    # source file.
    #
    # src  - Source file path.
    # dest - Destination file path.
    #
    # Returns TRUE when the destination is up to date, FALSE otherwise.
    static function upToDate($src, $dest)
    {
        if (!file_exists($dest)) {
            return false;
        }

        if (filemtime($dest) >= filemtime($src)) {
            return true;
        }
        return false;
    }

    static function relativize($path, $basePath = null)
    {
        if (null === $basePath) {
            $basePath = $_SERVER['PWD'];
        }

        $path = realpath($path);
        $basePath = realpath($basePath);

        if (false === $path) {
            throw new \InvalidArgumentException('Path does not exist.');
        }

        if (false === $basePath) {
            throw new \InvalidArgumentException('Base path does not exist.');
        }

        if (false === ($pos = strpos($path, $basePath))) {
            return $path;
        }

        return substr($path, strlen($basePath) + 1);
    }

    static function rel($path, $basePath = null)
    {
        return static::relativize($path, $basePath);
    }

    # Public: Sets the Current Working Directory to the path
    # given with `dir` and changes it back to the previous working
    # directory after running the callback.
    #
    # dir      - This directory becomes the CWD.
    # callback - The callback which should be run inside the CWD.
    # argv     - Additional arguments which should get passed to the
    #            callback.
    #
    # Returns the return value of the supplied callback.
    static function chdir($dir, $callback = null, $argv = array())
    {
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException("$dir does not exist.");
        }

        $cwd = getcwd();
        chdir($dir);

        if (null === $callback) {
            return;
        }

        $returnValue = call_user_func_array($callback, $argv);

        chdir($cwd);
        return $returnValue;
    }

    static function cd($dir, $callback = null, $argv = array()) 
    {
        return static::chdir($dir, $callback, $argv);
    }
}
