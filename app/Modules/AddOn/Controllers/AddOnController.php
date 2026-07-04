<?php

namespace App\Modules\AddOn\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AddOn\Models\AddOn;

use DB;
use Storage;
use Validator;

// curl -X POST http://localhost:8001/api/addons \
//     -H "Content-Type: application/json" \
//     -d '{
//         "name": "Chat",
//         "price": 49.99,
//         "installations": 17,
//         "projects": "[\"doctor_appointment_booking\"]"
//     }'

class AddOnController extends Controller
{
    public function store()
    {
        $validated = request()->validate([
            "name" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "installations" => "nullable|integer|min:0",
            "projects" => "nullable"
        ]);

        $user = auth("sanctum")->user();
        $user_id = $user->id;
        // $user_id = 1;

        $addon = new AddOn();
        $addon->name = $validated["name"];
        $addon->price = $validated["price"];
        $addon->installations = $validated["installations"] ?? 0;
        $addon->projects = $validated["projects"] ?? null;
        $addon->user_id = $user_id;

        $id = $addon->insert();

        return response()->json([
            "status" => "success",
            "id" => $id
        ]);
    }

    // READ (all)
    public function index()
    {
        $user = auth("sanctum")->user();

        $page = request()->page ?? 1;

        $addon = new AddOn();
        // $addon->user_id = $user->id;

        if (request()->has("name"))
            $addon->name = request()->name;

        if (request()->has("projects"))
            $addon->projects = request()->projects;

        $data = $addon->fetch($page);

        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    // READ (single)
    public function show($id)
    {
        $addon = new AddOn();
        $addon->id = $id;

        $data = $addon->fetch();

        return response()->json([
            "status" => "success",
            "data" => $data[0] ?? null
        ]);
    }

    public function update($id)
    {
        $validated = request()->validate([
            "name" => "sometimes|string|max:255",
            "price" => "sometimes|numeric|min:0",
            "installations" => "sometimes|integer|min:0",
            "projects" => "sometimes"
        ]);

        $addon = new AddOn();
        $addon->id = $id;

        foreach ($validated as $key => $value)
        {
            $addon->$key = $value;
        }

        $addon->update();

        return response()->json([
            "status" => "success",
        ]);
    }

    public function destroy($id)
    {
        $addon = new AddOn();
        $addon->id = $id;
        $addon->delete();

        return response()->json([
            "status" => "success",
        ]);
    }
}