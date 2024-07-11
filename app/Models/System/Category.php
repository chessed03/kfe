<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function hasRelated($item)
    {
        $result = (object)[
            'type'  => false,
            'find'  => ''
        ];

        $findRelations = '';

        if ($item->products()->exists()) {
            
            $result->type   = true;
            $findRelations .= 'productos';            
        }

        if ($result->type) {

            $result->find = "No se puede eliminar la categoría porque existen relacion con: {$findRelations}.";

        }

        return $result;
    }

    public static function getShowItems($key_word, $paginate_number, $order_by)
    {
        $query = self::query()
            ->where(function($query) use ($key_word) {
                $query->where('name', 'LIKE', '%' . $key_word . '%')
                    ->orWhere('description', 'LIKE', '%' . $key_word . '%');
            })
            ->where('is_active', self::ENABLED);

        switch ($order_by) {
            case 1:
                $query->orderBy('name', 'ASC');
                break;
            case 2:
                $query->orderBy('name', 'DESC');
                break;
            case 3:
                $query->orderBy('created_at', 'DESC');
                break;
            case 4:
                $query->orderBy('created_at', 'ASC');
                break;
            default:
                $query->orderBy('name', 'ASC');
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
            ->where('id', $id)
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
        $item               = new self();
        $item->name         = $data->name;
        $item->description  = $data->description;
        $item->is_active    = self::ENABLED;

        if($item->save()) {

            $result->type = true;

        }
        
        return $result;
    }

    public static function updateItem($data, $result)
    {
        $item       = self::find($data->selected_id);
        $hasRelated = self::hasRelated($item);
        $is_related = false;

        if ($data->is_active == self::DISABLED) {

            $is_related = $hasRelated->type;

        }

        if (!$is_related) {

            $item->name         = $data->name;
            $item->description  = $data->description;
            $item->is_active    = $data->is_active;

            if($item->update()) {

                $result->type = true;

            }

        } else {

            $result->find   = $hasRelated->find;

        }
                       
        return $result;
    }

    public static function disabledItem($id)
    {
        $result     = (object)[
            'type'  => false,
            'find'  => ''
        ];
        $item       = self::find($id);
        $hasRelated = self::hasRelated($item);
        
        if (!$hasRelated->type) {

            $item->is_active = self::DISABLED; 
        
            if($item->update()) {

                $result->type = true;

            } 

        } else {
            
            $result->find = $hasRelated->find;

        }

        return $result;
    }  
}
