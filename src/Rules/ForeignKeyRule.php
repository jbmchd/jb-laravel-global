<?php

namespace JbGlobal\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ForeignKeyRule implements ImplicitRule
{

    private $parameters;

    public function __construct($parameters){
        $this->parameters = $parameters;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $parameters = $this->parameters;

        $table = $parameters[0];
        $campoId = $parameters[1] ?? 'id';
        $model = null;

        if (Str::contains($table, '\\') && class_exists($table) && is_a($table, Model::class, true)) {
            $model = new $table;
            $table = $model->getTable();
        }

        $db_result = null;
        if($model){
            $db_result = $model->find($value);
        }
        else {
            $db_result = DB::table($table)->find($value);
        }

        return (float) $value >= 1 && !is_null($db_result) ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //
    }
}
