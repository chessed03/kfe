<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Price extends Model
{
    use HasFactory;

    protected $table = 'prices';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public static function saveItem($product_id, $price)
    {
        $result = (object)[
            'type'  => false,
            'find'  => ''
        ];
                
        $createItem = self::createItem($product_id, $price);
            
        return $createItem;
    }

    public static function createItem($product_id, $price)
    {
        $result             = false;

        self::query()
            ->where('product_id', $product_id)
            ->whereNull('end')
            ->update([
                'end'       => Carbon::now(), 
                'is_active' => self::DISABLED
            ]);

        $item               = new self();
        $item->product_id   = $product_id;
        $item->price        = $price;
        $item->start        = Carbon::now();
        $item->end          = null;
        $item->is_active    = self::ENABLED;

        if($item->save()) {
            
            $result = true;

        }

        return $result;
    }
}
