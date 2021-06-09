<?php

namespace App\Modules\Tutor\Jobs;

use App\Models\Podcast;
use Illuminate\Bus\Queueable;
use App\Modules\Shared\Cache\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Shared\Cache\FreshCacheInfo;
use App\Modules\Tutor\TutorRepositoryInterface;

class RebuildTutorCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tag;
    protected $slug;
    protected $tutor_repo;
    protected $method_name;

    /**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(
        $tag,
        $slug,
        TutorRepositoryInterface $tutor_repo,
        $method_name
    ) {
        $this->tag = $tag;
        $this->slug = $slug;
        $this->tutor_repo = $tutor_repo;
        $this->method_name = $method_name;
    }

    private function fetchResult()
    {
        $method_name = $this->method_name;
        return $this->tutor_repo->$method_name($this->slug);
    }
    
    public function handle(Cache $cache)
    {
        Log::info('start rebuild');
        $result = $this->fetchResult();
        $cache->set($this->tag, $this->slug, $result);
    }
}
