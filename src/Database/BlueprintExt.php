<?php

namespace JbGlobal\Database;

use Illuminate\Database\Schema\Blueprint as SchemaBlueprint;

class BlueprintExt
{
    public $BlueTable;

    public function __construct(SchemaBlueprint $table)
    {
        $this->BlueTable = $table;
    }

    public function foreign($field, $table, $ondelete='restrict', $onupdate='cascade')
    {
        return $this->BlueTable
            ->foreign($field)
            ->references('id')->on($table)
            ->onDelete($ondelete)->onUpdate($onupdate);
    }
}
