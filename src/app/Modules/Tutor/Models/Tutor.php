<?php

namespace App\Modules\Tutor\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = 'tutors';


    public function languages()
    {
        return $this->belongsToMany(Language::class, 'tutor_languages', 'tutor_id', 'language_id');
    }

    public function lesson_price()
    {
        return $this->hasOne(LessonPrice::class, 'tutor_id');
    }
}
