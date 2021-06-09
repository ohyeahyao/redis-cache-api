<?php
namespace App\Modules\Shared\Cache;

use Closure;
use Illuminate\Contracts\Queue\ShouldQueue;

class FreshCacheInfo
{
    public function __construct($tag, $key, $fresh_mins, ShouldQueue $rebuild_cache_job)
    {
        $this->tag = $tag;
        $this->key = $key;
        $this->fresh_mins = $fresh_mins;
        $this->rebuild_cache_job = $rebuild_cache_job;
    }

    public function needFresh($now, $create_at)
    {
        if ($now->subMinutes($this->fresh_mins)->greaterThanOrEqualTo($create_at)) {
            return true;
        }
        return false;
    }

    public function rebuildCallback()
    {
        return call_user_func($this->rebuild_callback);
    }

    public function tag()
    {
        return $this->tag;
    }

    public function key()
    {
        return $this->key;
    }

    public function job(): ShouldQueue
    {
        return $this->rebuild_cache_job;
    }
}
