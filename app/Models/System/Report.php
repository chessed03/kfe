<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public static function getSaleProductsByDateRange($date_start, $date_end)
    {
        return Sale::getItemProductsByDateRange($date_start, $date_end);
    }

    public static function getSaleProducts($take)
    {
        return Sale::getItemProducts($take);
    }
}
