<?php

namespace App\Helper;


class GlobRewriter
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

    public static function glob(string $pattern, $flags = null): array
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance->globWithMatches($pattern, $flags);

    }

    /**
     * TODO  implement cache
     * @param $pattern
     * @param $flags
     * @return array
     */
    protected function globWithMatches($pattern, $flags = null): array
    {
        $files = [];
        foreach (glob($pattern, $flags) as $originFilePath) {
            $overwritenFilePath = $this->findMatchesPathForOverwriting($originFilePath);
            if (null !== $overwritenFilePath && file_exists($overwritenFilePath)) {
                $files[] = $overwritenFilePath;
            } else {
                $files[] = $originFilePath;
            }
        }

        foreach (glob($this->findMatchesPathForOverwriting($pattern), $flags) as $replacedFilePath) {
            if(false === array_search($replacedFilePath, $files)){
                $files[] = $replacedFilePath;
            }
        }

        return $files;
    }




}