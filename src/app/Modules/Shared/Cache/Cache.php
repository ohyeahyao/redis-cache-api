<?php
namespace App\Modules\Shared\Cache;

use InvalidArgumentException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class Cache
{
    /**
     * @var Carbon
     */
    private $now;
    public function __construct(
        Carbon $now
    ) {
        $this->cache_cli = Redis::connection();
        $this->now = $now;
    }

    public function has($tag, $key)
    {
        $index = $this->cacheIndex($tag, $key);
        return $this->cache_cli->exists($index);
    }

    private function rebuild(FreshCacheInfo $fresh_info)
    {
        dispatch(($fresh_info->job()));
    }

    private function keepFresh($created_at, FreshCacheInfo $fresh_info)
    {
        try {
            $create_at = Carbon::parse($created_at);
        } catch (InvalidArgumentException $e) {
            return;
        }

        if ($fresh_info->needFresh($this->now, $create_at)) {
            $this->rebuild($fresh_info);
        }
    }

    private function getAllValue($index)
    {
        return unserialize($this->cache_cli->get($index));
    }
    
    private function cacheIndex($tag, $key)
    {
        return "{$tag}#{$key}";
    }

    public function get(FreshCacheInfo $fresh_info)
    {
        $index = $this->cacheIndex($fresh_info->tag(), $fresh_info->key());
        $value = $this->getAllValue($index);
        
        if ($value instanceof CacheObject) {
            $created_at = $value->created_at ?? null;
            $this->keepFresh($created_at, $fresh_info);
            return $value->value;
        }
        
        return $value ?? null;
    }

    public function set($tag, $key, $value)
    {
        $index = $this->cacheIndex($tag, $key);
        $object = new CacheObject($index, $value, $this->now->toDateTimeString());
        Redis::set($index, serialize($object));
    }
}
