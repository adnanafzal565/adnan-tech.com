<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

use App\Models\Subscriber;
use App\Mail\NewSubscriberNotification;

class NewsletterController extends Controller
{
    public function index()
    {
        set_timezone();
        
        $subscribers = Subscriber::orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view("admin/subscribers/index", [
            "subscribers" => $subscribers
        ]);
    }

    /**
     * Handle a newsletter subscription request (AJAX).
     */
    public function subscribe(Request $request): JsonResponse
    {
        // 1. Validate the email format up front.
        $validated = $request->validate([
            'email' => ['required', 'email:rfc,dns', 'max:255'],
        ]);
 
        $email = strtolower(trim($validated['email']));
 
        // 2. Check if already subscribed.
        $existing = Subscriber::where('email', $email)->first();
 
        if ($existing) {
            return response()->json([
                'message' => "You're already subscribed to our newsletter.",
            ], 200);
        }
 
        // 3. Save the new subscriber.
        $subscriber = Subscriber::create([
            'email' => $email,
            'subscribed_at' => now()->utc(),
        ]);
 
        if (config("app.env") === "production") {
            // 4. Notify the admin. Don't let a mail failure break the signup response.
            try {
                Mail::to(admin_email())
                    ->send(new NewSubscriberNotification($subscriber));
            } catch (Throwable $e) {
                report($e);
            }
        }
 
        return response()->json([
            'message' => "You're subscribed! Thanks for joining.",
        ], 201);
    }
}
