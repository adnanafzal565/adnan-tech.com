<?php

namespace App\Services;

use App\Models\FormAttempt;
use Illuminate\Support\Str;

class FormAttemptService
{
    public function create(string $form_type): string
    {
        $token = Str::random(64);

        FormAttempt::create([
            "token" => hash("sha256", $token),
            "form_type" => $form_type,
            "started_at" => now()->utc(),
        ]);

        return $token;
    }

    public function validate(
        string $token,
        string $form_type,
        int $minimum_seconds = 3
    ): FormAttempt {
        $form_attempt = FormAttempt::where("token", hash("sha256", $token))
            ->where("form_type", $form_type)
            ->first();

        if (!$form_attempt) {
            abort(404);
        }

        if ($form_attempt->started_at->diffInSeconds(now()->utc()) < $minimum_seconds) {
            abort(404);
        }

        $form_attempt->delete();

        return $form_attempt;
    }
}