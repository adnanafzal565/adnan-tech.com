<?php

namespace App\Modules\AddOn\Models;

use DB;
use App\Modules\AddOn\Models\Model;

class AddOn extends Model
{
    private $table = "addons";

    public $id;
    public $user_id;
    public $name;
    public $price;
    public $installations;
    public $projects;

    public function insert()
    {
        return DB::table($this->table)
            ->insertGetId([
                "user_id"       => $this->user_id,
                "name"          => $this->name,
                "price"         => $this->price,
                "installations" => $this->installations,
                "projects"      => $this->projects,
                "created_at"    => now()->utc(),
                "updated_at"    => now()->utc(),
            ]);
    }

    public function update()
    {
        $obj = [
            "updated_at" => now()->utc(),
        ];

        if (isset($this->user_id))
            $obj["user_id"] = $this->user_id;

        if (isset($this->name))
            $obj["name"] = $this->name;

        if (isset($this->price))
            $obj["price"] = $this->price;

        if (isset($this->installations))
            $obj["installations"] = $this->installations;

        if (isset($this->projects))
            $obj["projects"] = $this->projects;

        DB::table($this->table)
            ->where("id", "=", $this->id)
            ->update($obj);
    }

    public function map($d)
    {
        $obj = [
            "id"            => $d->id ?? 0,
            "user_id"       => $d->user_id ?? 0,
            "name"          => $d->name ?? "",
            "price"         => $d->price ?? 0,
            "installations" => $d->installations ?? 0,
            "projects"      => json_decode($d->projects ?? "[]", true),
            "created_at"    => date("j F, Y", strtotime($d->created_at)),
            "updated_at"    => date("j F, Y", strtotime($d->updated_at)),
        ];

        return (object) $obj;
    }

    public function fetch($page = 1)
    {
        $data = DB::table($this->table);

        if (isset($this->id))
            $data = $data->where("id", "=", $this->id);

        if (isset($this->user_id))
            $data = $data->where("user_id", "=", $this->user_id);

        if (isset($this->name))
            $data = $data->where("name", "LIKE", "%" . $this->name . "%");

        if (isset($this->price))
            $data = $data->where("price", "=", $this->price);

        if (isset($this->installations))
            $data = $data->where("installations", "=", $this->installations);

        if (isset($this->projects))
            $data = $data->whereJsonContains("projects", $this->projects);

        $total = $data->count();

        $perPage = config("config.pagination");

        $results = $data->orderBy("id", "desc")
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $arr = [];
        foreach ($results as $d)
            $arr[] = $this->map($d);

        return [
            "data" => $arr,
            "total" => $total,
            "page" => $page,
            "per_page" => $perPage
        ];
    }

    public function delete()
    {
        return DB::table($this->table)
            ->where("id", "=", $this->id)
            ->delete();
    }
}