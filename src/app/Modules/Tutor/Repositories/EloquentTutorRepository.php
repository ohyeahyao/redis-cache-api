<?php
namespace App\Modules\Tutor\Repositories;

use Illuminate\Support\Facades\DB;
use App\Modules\Tutor\Models\Tutor;
use App\Modules\Tutor\Models\Language;
use App\Modules\Tutor\TutorRepositoryInterface;

class EloquentTutorRepository implements TutorRepositoryInterface
{
    public function fetchByLanguageSlug(string $language_slug)
    {
        return Tutor::query()
                ->select([
                    'tutors.id','tutors.name','tutors.headline','tutors.introduction'
                ])
                ->with(['languages', 'lesson_price'])
                ->join('tutor_languages', 'tutor_languages.tutor_id', '=', 'tutors.id')
                ->join('languages', 'tutor_languages.language_id', '=', 'languages.id')
                ->where('languages.slug', $language_slug)
                ->get();
    }

    public function findBySlug(string $tutor_slug)
    {
        return Tutor::with(['languages', 'lesson_price'])->where('slug', $tutor_slug)->first();
    }
}
