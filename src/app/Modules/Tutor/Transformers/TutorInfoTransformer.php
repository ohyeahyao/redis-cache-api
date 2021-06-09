<?php

namespace App\Modules\Tutor\Transformers;

use App\Modules\Tutor\Models\Tutor;
use App\Modules\Tutor\Models\LessonPrice;
use Illuminate\Database\Eloquent\Collection;

class TutorInfoTransformer
{
    public function toArray(Tutor $tutor): array
    {
        return [
            "name" => $tutor->name,
            "headline" => $tutor->headline,
            "introduction" => $tutor->introduction,
            "price_info" => $this->priceInfo($tutor->lesson_price),
            "teaching_languages" => $this->languageIds($tutor->languages)
        ];
    }

    private function priceInfo(LessonPrice $lesson_price): array
    {
        return [
            'trial' => $lesson_price->trial_price,
            'normal' => $lesson_price->normal_price,
        ];
    }

    private function languageIds(Collection $languages): array
    {
        return $languages->pluck('id')->toArray();
    }
}
