<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait RenderIdNumberTrait
{

    /**
     * @param $model
     * @param string $column
     * @return false|string
     */
    public function renderNumber($model, string $column = 'user_number')
    {
        if (empty($model) && empty($model->getTable())) {
            return false;
        }

        $table = $model->getTable();
        $num = DB::table($table)
            ->select(DB::raw("CONVERT(SUBSTRING_INDEX($column,'-',-1),UNSIGNED INTEGER) AS num"))
            ->latest('id')
            ->value('num');
        $num = empty($num) ? 1 : $num + 1;
        return "PER-". str_pad($num, 3, 0, STR_PAD_LEFT);
    }
}
