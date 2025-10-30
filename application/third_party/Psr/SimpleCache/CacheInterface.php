<?php

namespace Psr\SimpleCache;

/**
 * Dummy CacheInterface for PhpSpreadsheet (manual install)
 * Only to prevent ReflectionException when PSR package not installed.
 */
interface CacheInterface
{
    public function get($key, $default = null);
    public function set($key, $value, $ttl = null);
    public function delete($key);
    public function clear();
    public function getMultiple($keys, $default = null);
    public function setMultiple($values, $ttl = null);
    public function deleteMultiple($keys);
    public function has($key);
}