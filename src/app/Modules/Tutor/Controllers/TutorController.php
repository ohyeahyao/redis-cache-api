<?php

namespace App\Modules\Tutor\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Tutor\Services\FetchTutor;
use App\Modules\Tutor\Exceptions\TutorException;
use App\Modules\Tutor\Transformers\TutorInfoTransformer;

class TutorController extends Controller
{
    public function tutorsBoard($language_slug)
    {
        $service = app()->make(FetchTutor::class);
        $tutors = $service->fetchByLanguageSlug($language_slug);

        $transformer = new TutorInfoTransformer();

        $data = $tutors->map(function ($tutor) use ($transformer) {
            return $transformer->toArray($tutor);
        });

        return response()->json(['data' => $data]);
    }

    public function show($tutor_slug)
    {
        try {
            $service = app()->make(FetchTutor::class);
            $tutor = $service->findByTutorSlug($tutor_slug);
            $transformer = new TutorInfoTransformer();
            $data = $transformer->toArray($tutor);

            return response()->json(['data' => $data]);
        } catch (TutorException $e) {
            return response()->json($e->getMessage(), 422);
        } catch (Exception $e) {
            Log::info('opps something error'. $e->getMessage());
            return response()->json('server error', 500);
        }
    }
}
