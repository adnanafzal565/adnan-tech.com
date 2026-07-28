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
            ->orderBy('name', 'ASC')
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

        $has_api_key = ApiKey::where("user_id", auth()->id())->exists();

        $api_key = ApiKey::create([
            "user_id" => auth()->id(),
            "name" => $request->name,
            "key" => Str::random(64),
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
