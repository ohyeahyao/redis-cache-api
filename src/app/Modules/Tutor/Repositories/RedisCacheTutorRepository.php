<?php
namespace App\Modules\Tutor\Repositories;

use App\Modules\Shared\Cache\Cache;
use App\Modules\Shared\Cache\FreshCacheInfo;
use App\Modules\Tutor\Jobs\RebuildTutorCache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Modules\Tutor\TutorRepositoryInterface;

class RedisCacheTutorRepository implements TutorRepositoryInterface
{
    private $tutor_repo;

    const TUTOR_FETCH_BY_LANGUAGE_SLUG = 'TUTOR_FETCH_BY_LANGUAGE_SLUG';
    const TUTOR_FIND_BY_TUTOR_SLUG = 'TUTOR_FIND_BY_TUTOR_SLUG';

    /**
     * 分鐘
     */
    const FRESH_MINS = [
        self::TUTOR_FETCH_BY_LANGUAGE_SLUG => [
            "english" => 3,
            "chinsese" => 5,
            "japanese" => 10
        ],
        self::TUTOR_FIND_BY_TUTOR_SLUG => 10
    ];

    public function __construct(
        TutorRepositoryInterface $tutor_repo,
        Cache $cache
    ) {
        $this->tutor_repo = $tutor_repo;
        $this->cache = $cache;
    }
    
    public function fetchByLanguageSlug(string $language_slug)
    {
        if ($this->cache->has(self::TUTOR_FETCH_BY_LANGUAGE_SLUG, $language_slug)) {
            Log::info("has cache {self::TUTOR_FETCH_BY_LANGUAGE_SLUG}#{$language_slug}");

            $fresh_mins = self::FRESH_MINS[self::TUTOR_FETCH_BY_LANGUAGE_SLUG][$language_slug];

            return $this->cache->get(
                new FreshCacheInfo(
                    self::TUTOR_FETCH_BY_LANGUAGE_SLUG,
                    $language_slug,
                    $fresh_mins,
                    new RebuildTutorCache(
                        self::TUTOR_FETCH_BY_LANGUAGE_SLUG,
                        $language_slug,
                        $this->tutor_repo,
                        'fetchByLanguageSlug'
                    )
                )
            );
        }
            
        $result =  $this->tutor_repo->fetchByLanguageSlug($language_slug);
        Log::info("create cache {self::TUTOR_FETCH_BY_LANGUAGE_SLUG}#{$language_slug}");
        $this->cache->set(self::TUTOR_FETCH_BY_LANGUAGE_SLUG, $language_slug, $result);
        return $result;
    }



    public function findBySlug(string $tutor_slug)
    {
        if ($this->cache->has(self::TUTOR_FIND_BY_TUTOR_SLUG, $tutor_slug)) {
            Log::info("has cache {self::TUTOR_FIND_BY_TUTOR_SLUG}#{$tutor_slug}");

            $fresh_mins = self::FRESH_MINS[self::TUTOR_FIND_BY_TUTOR_SLUG];

            return $this->cache->get(
                new FreshCacheInfo(
                    self::TUTOR_FIND_BY_TUTOR_SLUG,
                    $tutor_slug,
                    $fresh_mins,
                    new RebuildTutorCache(
                        self::TUTOR_FIND_BY_TUTOR_SLUG,
                        $tutor_slug,
                        $this->tutor_repo,
                        'findBySlug'
                    )
                )
            );
        }

        $result =  $this->tutor_repo->findBySlug($tutor_slug);
        Log::info("create cache {self::TUTOR_FIND_BY_TUTOR_SLUG}#{$tutor_slug}");
        $this->cache->set(self::TUTOR_FIND_BY_TUTOR_SLUG, $tutor_slug, $result);
        return $result;
    }
}
