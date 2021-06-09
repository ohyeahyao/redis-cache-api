<?php

namespace App\Modules\Tutor\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class, 'tutor_languages', 'language_id', 'tutor_id');
    }
}
