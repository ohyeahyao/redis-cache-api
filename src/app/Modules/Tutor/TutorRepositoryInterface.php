<?php

namespace App\Modules\Tutor;

interface TutorRepositoryInterface
{
    public function fetchByLanguageSlug(string $language_slug);

    public function findBySlug(string $tutor_slug);
}
