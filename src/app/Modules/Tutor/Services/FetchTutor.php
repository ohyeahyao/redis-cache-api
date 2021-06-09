<?php

namespace App\Modules\Tutor\Services;

use App\Modules\Tutor\Exceptions\TutorException;
use App\Modules\Tutor\TutorRepositoryInterface;

class FetchTutor
{
    /**
     * @var TutorRepositoryInterface
     */
    private $tutor_repo;

    public function __construct(TutorRepositoryInterface $tutor_repo)
    {
        $this->tutor_repo = $tutor_repo;
    }
    
    public function fetchByLanguageSlug(string $language_slug)
    {
        return $this->tutor_repo->fetchByLanguageSlug($language_slug);
    }

    public function findByTutorSlug(string $tutor_slug)
    {
        $tutor = $this->tutor_repo->findBySlug($tutor_slug);
        if (is_null($tutor)) {
            throw new TutorException('Not Found Tutor');
        }
        
        return $tutor;
    }
}
