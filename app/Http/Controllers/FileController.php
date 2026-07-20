<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Validator;

class FileController extends Controller
{
    public function destroy()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $id = request()->id ?? 0;
        $media = DB::table('files')->where('id', $id)->first();

        if (!$media)
        {
            return response()->json([
                "status" => "error",
                "message" => "File not found."
            ]);
        }

        if ($media->file_path && Storage::exists($media->type . "/" . $media->file_path))
        {
            Storage::delete($media->type . "/" . $media->file_path);
        }

        DB::table('files')->where('id', $id)->delete();

        return response()->json([
            "status" => "success",
            "message" => "File has been deleted."
        ]);
    }

    public function bulk_upload()
    {
        $validator = Validator::make(request()->all(), [
            "type" => "required|in:private,public",
            "files" => "required|array|min:1",
            "files.*" => "required|file",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $type = request()->type;
        $year = now()->year;
        $uploadedFiles = [];

        foreach (request()->file("files") as $file) {

            $name = $file->getClientOriginalName();
            $filePath = "files/" . $year . '/' . uniqid() . "." . $file->getClientOriginalExtension();

            $file->storeAs("/" . $type, $filePath);

            if (!is_dir(storage_path("app/" . $type. "/files"))) {
                mkdir(storage_path("app/" . $type . "/files"), 0755, true);
            }

            chmod(storage_path("app/" . $type . "/files"), 0755);

            $id = DB::table("files")->insertGetId([
                "file_path"  => $filePath,
                "name" => $name,
                "type" => $type,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc(),
            ]);

            $uploadedFiles[] = [
                "id" => $id,
                "file_path" => url("/storage/" . $filePath),
            ];
        }

        return response()->json([
            "status" => "success",
            "message" => "Files have been uploaded.",
            "files" => $uploadedFiles,
        ]);
    }

    public function upload()
    {
        $validator = Validator::make(request()->all(), [
            "file" => "required",
            "type" => "required"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->first()
            ]);
        }

        $type = request()->type ?? "";
        $year = now()->year;
        $file = request()->file("file");

        if (!in_array($type, ["public", "private"]))
        {
            return response()->json([
                "status" => "error",
                "message" => "In-valid type '" . $type . "'."
            ]);
        }

        $data = [
            'name'        => request()->name ?? "",
            'file_path'   => "",
            'alt'         => request()->alt ?? "",
            'caption'     => request()->caption ?? "",
            'description' => request()->description ?? "",
            'created_at'  => now()->utc(),
            'updated_at'  => now()->utc()
        ];

        $file_path = "";

        if ($file)
        {
            $file_path = "files/" . $year . '/' . uniqid() . "." . $file->getClientOriginalExtension();
            $file->storeAs("/" . $type, $file_path);
            chmod(storage_path("app/" . $type . "/files"), 0755);

            $data["file_path"] = $file_path;
        }

        $id = DB::table('files')->insertGetId($data);

        return response()->json([
            "status" => "success",
            "message" => "File has been uploaded.",
            "id" => $id,
            "file_path" => url("/storage/" . $file_path)
        ]);
    }

    public function index()
    {
        if (request()->isMethod("post"))
        {
            set_timezone();

            $files = DB::table('files')
                ->where("type", "=", "public")
                ->orderByDesc('id')
                ->paginate(1000000);

            $files_arr = [];
            foreach ($files as $file)
            {
                $obj = [
                    "id" => $file->id ?? 0,
                    "name" => $file->name ?? "",
                    "file_path" => $file->file_path ?? "",
                    "alt" => $file->alt ?? "",
                    "caption" => $file->caption ?? "",
                    "description" => $file->description ?? "",
                    "created_at" => date("d F, Y h:i:s a", strtotime($file->created_at . " UTC"))
                ];

                if ($obj["file_path"] && Storage::exists("public/" . $obj["file_path"]))
                {
                    $obj["file_path"] = url("/storage/" . $obj["file_path"]);
                }

                array_push($files_arr, (object) $obj);
            }

            return response()->json([
                "status" => "success",
                "message" => "Data has been fetched.",
                "files" => $files_arr
            ]);
        }

        $search = request()->search ?? "";

        $files = DB::table('files');
        if (!empty($search))
        {
            $files = $files->where(function ($query) use ($search) {
                $query->where("name", "LIKE", "%" . $search . "%")
                    ->orWhere("alt", "LIKE", "%" . $search . "%")
                    ->orWhere("caption", "LIKE", "%" . $search . "%")
                    ->orWhere("description", "LIKE", "%" . $search . "%");
            });
        }
        $files = $files->orderByDesc('id')->paginate(1000000);

        return view("admin/files/index", [
            "files" => $files,
            "search" => $search
        ]);
    }
}
