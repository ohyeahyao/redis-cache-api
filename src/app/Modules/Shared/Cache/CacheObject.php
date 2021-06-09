<?php
namespace App\Modules\Shared\Cache;

class CacheObject
{
    public function __construct($index, $value, $created_at)
    {
        $this->index = $index;
        $this->value = $value;
        $this->created_at = $created_at;
    }
}
