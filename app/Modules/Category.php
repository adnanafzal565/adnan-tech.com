<?php

namespace App\Modules;

use DB;

class Category extends Module
{
    private $table = "categories";

    public $id, $name;

    public function __construct($id = null, $name = null)
    {
        parent::__construct($this->table, $id);
        $this->id = $id;
        $this->name = $name;
    }

    public function map($data)
    {
        $obj = [
            "id" => $data->id ?? 0,
            "name" => $data->name ?? ""
        ];

        return (object) $obj;
    }

    public function fetch()
    {
        $data = DB::table($this->table);
        
        if (isset($this->id))
            $data = $data->where("id", "=", $this->id);

        if (isset($this->name))
            $data = $data->where("name", "=", $this->name);

        $data = $data->get();

        $arr = [];
        foreach ($data as $d)
            $arr[] = $this->map($d);

        return $arr;
    }

    public function fetch_single()
    {
        $data = DB::table($this->table);
        
        if (isset($this->id))
            $data = $data->where("id", "=", $this->id);

        if (isset($this->name))
            $data = $data->where("name", "=", $this->name);

        $data = $data->first();

        if ($data == null)
            return null;

        return $this->map($data);
    }

    public function add()
    {
        return DB::table($this->table)
            ->insertGetId([
                "name" => $this->name,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc(),
            ]);
    }
}