<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getShowItems($key_word, $paginate_number, $order_by)
    {
        $query = self::query()
            ->leftJoin('prices', 'products.id', '=', 'prices.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as id',
                'products.code as code',
                'products.name as name',
                'products.is_active as is_active',
                'categories.name as category',
                'prices.price as price',
            )
            ->where(function($query) use ($key_word) {
                $query->where('products.code', 'LIKE', '%' . $key_word . '%')
                    ->orWhere('products.name', 'LIKE', '%' . $key_word . '%')
                    ->orWhere('products.description', 'LIKE', '%' . $key_word . '%');
            })
            ->where('prices.is_active', Price::ENABLED)
            ->where('products.is_active', self::ENABLED);

        switch ($order_by) {
            case 1:
                $query->orderBy('products.name', 'ASC');
                break;
            case 2:
                $query->orderBy('products.name', 'DESC');
                break;
            case 3:
                $query->orderBy('products.created_at', 'DESC');
                break;
            case 4:
                $query->orderBy('products.created_at', 'ASC');
                break;
            default:
                $query->orderBy('products.name', 'ASC');
                break;
        }

        return $query->paginate($paginate_number);
    }

    public static function getItems()
    {
        $query = self::query()
            ->where('is_active', self::ENABLED)
            ->get();

        return $query;
    }

    public static function getItemById($id)
    {
        $result = false;
        $query  = self::query()
            ->leftJoin('prices', 'products.id', '=', 'prices.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as id',
                'products.code as code',
                'products.name as name',
                'products.is_active as is_active',
                'products.description as description',
                'categories.id as category_id',
                'prices.price as price',
            )
            ->where('products.id', $id)
            ->first();

        if ($query) {

            $result = $query;

        }

        return $result;
    }

    public static function getItemByCode($product_code)
    {
        $result = false;
        $query  = self::query()
            ->leftJoin('prices', 'products.id', '=', 'prices.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as id',
                'products.code as code',
                'products.name as name',
                'prices.price as price',
            )
            ->where('prices.is_active', Price::ENABLED)
            ->where('products.is_active', self::ENABLED)
            ->where('products.code', $product_code)
            ->first();

        if ($query) {

            $result = $query;

        }

        return $result;
    }

    public static function saveItem($data)
    {
        $result = (object)[
            'type'  => false,
            'find'  => ''
        ];
        
        if ($data->update_mode) {

            $updateItem = self::updateItem($data, $result);

            return $updateItem;            

        } else {

            $createItem = self::createItem($data, $result);
            
            return $createItem;

        }
    }

    public static function createItem($data, $result)
    {
        $validateCode = self::validateCode($data->code, null);

        if (!$validateCode) {

            $item               = new self();
            $item->category_id  = $data->category_id;
            $item->code         = $data->code;
            $item->name         = $data->name;
            $item->description  = $data->description;
            $item->is_active    = self::ENABLED;

            if($item->save()) {
                
                Price::saveItem($item->id, $data->price);
                $result->type = true;

            }

        } else {

            $result->false = true;
            $result->find  = 'El código ya fué asignado a un producto.';

        }

        return $result;
    }

    public static function updateItem($data, $result)
    {
        $validateCode = self::validateCode($data->code, $data->selected_id);

        if (!$validateCode) {

            $item               = self::find($data->selected_id);
            $item->category_id  = $data->category_id;
            $item->code         = $data->code;
            $item->name         = $data->name;
            $item->description  = $data->description;
            $item->is_active    = $data->is_active;

            if($item->update()) {
                
                if ($data->price_update) {

                    Price::saveItem($item->id, $data->price);

                }
                
                $result->type = true;

            }

        } else {

            $result->false = true;
            $result->find  = 'El código ya fué asignado a un producto.';

        }

        return $result;
    }

    public static function disabledItem($id)
    {
        $result     = (object)[
            'type'  => false,
            'find'  => ''
        ];

        $item               = self::find($id);
        $item->is_active    = self::DISABLED; 
    
        if($item->update()) {

            $result->type = true;

        } 

        return $result;
    }

    public static function validateCode($code, $selected_id)
    {
        $result = false;
        $query  = self::query()
            ->where('code', $code);
        
        if ($selected_id) {

            $query->where('id', '!=',$selected_id);$query->where('id', '!=', $selected_id);

        }

        $validation = $query->exists();
      
        if ($validation) {
            
            $result = true;
            
        }

        return $result;
    }

    public static function getCategories()
    {
        return Category::getItems();
    }
}
