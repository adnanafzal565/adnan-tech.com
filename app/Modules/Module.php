<?php

namespace App\Modules;

use DB;

class Module
{
    private $table = "";

    protected $id;

    public function __construct($table = null, $id = null)
    {
        $this->table = $table;
        $this->id = $id;
    }

    public function count()
    {
        return DB::table($this->table)->count();
    }

    public function delete()
    {
        DB::table($this->table)
            ->where("id", "=", $this->id)
            ->update([
                "deleted_at" => now()->utc()
            ]);
    }
}