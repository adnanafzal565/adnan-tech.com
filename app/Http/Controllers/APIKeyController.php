<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Str;
use Validator;

use App\Models\ApiKey;
use App\Models\ApiKeyRequestLog;

class ApiKeyController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "remaining" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $api_key = ApiKey::find($request->id);

        if (!$api_key) {
            return response()->json([
                "status" => "error",
                "message" => "API key not found."
            ]);
        }

        $api_key->remaining = $request->remaining;
        $api_key->save();

        return response()->json([
            "status" => "success",
            "message" => "API key has been updated."
        ]);
    }

    public function edit(Request $request)
    {
        $api_key = ApiKey::findOrFail($request->id);

        return view('admin/api_keys/edit', [
            "api_key" => $api_key
        ]);
    }

    public function fetch_history(Request $request)
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
            ->first();

        if (!$api_key) {
            return response()->json([
                "status" => "error",
                "message" => "API key not found."
            ]);
        }

        $history = ApiKeyRequestLog::where("api_key_id", $api_key->id)
            ->orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return response()->json([
            "status" => "success",
            "api_key" => $api_key,
            "history" => $history,
        ]);
    }

    public function history(Request $request)
    {
        return view("theme::api_keys/history", [
            "id" => $request->id
        ]);
    }

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
            ->first();

        if (!$api_key) {
            return response()->json([
                "status" => "error",
                "message" => "API key not found."
            ]);
        }


        $api_key->update([
            "status" => !$api_key->status,
        ]);


        return response()->json([
            "status" => "success",
            "key_status" => $api_key->status,
        ]);
    }

    public function admin_index()
    {
        set_timezone();

        $api_keys = ApiKey::with(["user"])
            ->orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view('admin/api_keys/index', [
            "api_keys" => $api_keys
        ]);
    }

    public function index()
    {
        return view('theme::api_keys/index');
    }

    public function fetch_all()
    {
        $api_keys = ApiKey::where('user_id', auth()->id())
            ->where("status", 1)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'api_keys' => $api_keys,
        ]);
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
