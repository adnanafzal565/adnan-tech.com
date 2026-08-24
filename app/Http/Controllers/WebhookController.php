<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Str;

class WebhookController extends Controller
{
    /**
     * Revoke the authenticated user's webhook secret entirely.
     */
    public function delete(Request $request)
    {
        auth()->user()->forceFill([
            'webhook_secret_hash' => null,
            'webhook_secret_encrypted' => null,
            'webhook_secret_generated_at' => null,
        ])->save();
 
        return response()->json([
            'status' => 'success',
            'message' => 'Webhook secret has been removed.'
        ]);
    }

    /**
     * Generate (or regenerate) the authenticated user's webhook secret.
     * The plaintext secret is returned ONLY in this response — it is
     * never stored or logged, and cannot be retrieved again afterwards.
     */
    public function generate(Request $request)
    {
        $plainSecret = 'whsec_' . Str::random(40);
 
        auth()->user()->forceFill([
            'webhook_secret_hash' => hash_secret($plainSecret),
            'webhook_secret_encrypted' => Crypt::encryptString($plainSecret),
            'webhook_secret_generated_at' => now()->utc(),
        ])->save();
 
        return response()->json([
            'status' => 'success',
            'message' => 'Copy this secret now — it will not be shown again.',
            'secret' => $plainSecret,
        ]);
    }
}
