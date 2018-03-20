<?php

namespace App\Helper;


class FileExiststRewriter
{
    protected $cache;
    use FilesTrait;
    /**
     * @var GlobRewriter
     */
    protected static $instance;

    public function __construct(\Cache $cache = null)
    {
        $this->cache = $cache;
        static::$instance = $this;
    }

    /**
     * TODO implement cache
     * @param string $filePath
     * @return null|string
     */
    public static function fileExists(string $filePath)
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        $rewritenFilePath = static::$instance->findMatchesPathForOverwriting($filePath);

        if(null!== $rewritenFilePath && file_exists($rewritenFilePath)){
            return $rewritenFilePath;
        }
        if(file_exists($filePath)){
            return $filePath;
        }
        return null;
    }

}