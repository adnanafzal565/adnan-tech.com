<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Str;
use Validator;
use App\Models\ApiKey;

class APIKeyController extends Controller
{
    public function toggle_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $api_key = ApiKey::where("id", $request->id)
            ->where("user_id", auth()->id())
            ->firstOrFail();


        $api_key->update([
            "status" => !$api_key->status,
        ]);


        return response()->json([
            "status" => "success",
            "key_status" => $api_key->status,
        ]);
    }

    public function index()
    {
        return view('theme::api_keys/index');
    }

    public function fetch()
    {
        $api_keys = ApiKey::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->paginate(config("config.PER_PAGE"));

        return response()->json([
            'status' => 'success',
            'data' => $api_keys,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $api_key_same_name = ApiKey::where("user_id", auth()->id())
            ->where("name", $request->name)
            ->exists();

        if ($api_key_same_name) {
            return response()->json([
                "status" => "error",
                "message" => "API key with same name already exists in your account."
            ]);
        }

        $has_api_key = ApiKey::where("user_id", auth()->id())->exists();

        $api_key = ApiKey::create([
            "user_id" => auth()->id(),
            "name" => $request->name,
            "key" => Str::uuid()->toString() . Str::random(32),
            "status" => 1,
            "remaining" => $has_api_key
                ? 0
                : config("config.free_api_requests_per_key"),
        ]);

        return response()->json([
            "status" => "success",
            "message" => "API key created successfully.",
            "data" => $api_key,
        ]);
    }
}
