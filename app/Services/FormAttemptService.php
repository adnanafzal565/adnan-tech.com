<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

use App\Models\FormAttempt;

class FormAttemptService
{
    public function validate_rate_limit(
        string $form_type,
        int $maximum_attempts = 5
    ): void
    {
        $ip_address = request()->ip();

        $cache_key = "form_rate_limit:{$form_type}:{$ip_address}";

        $attempts = (int) Cache::get($cache_key, 0);

        if ($attempts >= $maximum_attempts) {
            abort(429, "Too many submissions.");
        }

        Cache::put(
            $cache_key,
            $attempts + 1,
            now()->utc()->addHour()
        );
    }

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
        if (empty($token)) {
            abort(404);
        }

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