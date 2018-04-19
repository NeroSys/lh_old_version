<?php

namespace App\Engine\Cache;

use \Psr\SimpleCache\CacheInterface;

require_once DIR_OPENCART . 'system/library/cache.php';

class Memcached extends \Cache implements CacheInterface
{
    /**
     * @var Memcached
     */
    private $memcached;
    private $expire_in_seconds = 3600;

    public function __construct()
    {
        $this->memcached = $this->createConnection();
    }

    private function createConnection()
    {
        if (!class_exists('Memcached')) {
            throw new \Exception("Memcached не установлен/ сначала установите его");
        }

        $cache = new \Memcached();
        $cache->addServer('localhost', 11211);

        return $cache;
    }


    public function get($key, $default = null)
    {
        return $this->memcached->get($key);
    }

    public function set($key, $value, $ttl = null)
    {
        $this->memcached->set($key, $value, $this->expire_in_seconds);
    }

    public function delete($key)
    {
        $this->memcached->delete($key);
    }

    public function clear()
    {
        $this->memcached->flush();
    }

    public function getMultiple($keys, $default = null)
    {
        throw new \Exception('its is not implement yet');
    }

    public function setMultiple($keys, $default = null)
    {
        throw new \Exception('its is not implement yet');
    }

    public function deleteMultiple($keys)
    {
        throw new \Exception('its is not implement yet');
    }

    public function has($key)
    {
        return $this->memcached->get($key) ? true: false;
    }
}
