<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public static function getShowItems($key_word, $paginate_number, $order_by)
    {
        $query = self::query()
            ->where(function($query) use ($key_word) {
                $query->where('name', 'LIKE', '%' . $key_word . '%')
                    ->orWhere('email', 'LIKE', '%' . $key_word . '%');
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
        $validateEmail = self::validateEmail($data->email, null);

        if (!$validateEmail) {

            $item               = new self();
            $item->name         = $data->name;
            $item->email        = $data->email;
            $item->type_id      = $data->type_id;
            $item->password     = Hash::make($data->password);
            $item->is_active    = self::ENABLED;

            if($item->save()) {

                $result->type = true;

            }

        } else {

            $result->false = true;
            $result->find  = 'El correo electrónico ya está en uso.';

        }
        
        return $result;
    }

    public static function updateItem($data, $result)
    {
        $validateEmail = self::validateEmail($data->email, $data->selected_id);

        if (!$validateEmail) {

            $item = self::find($data->selected_id);
                        
            if ($data->password_update) {

                $item->password = Hash::make($data->password);

            }

            $item->name         = $data->name;
            $item->email        = $data->email;
            $item->type_id      = $data->type_id;            
            $item->is_active    = $data->is_active;

            if($item->update()) {

                $result->type = true;

            }

        } else {

            $result->false = true;
            $result->find  = 'El correo electrónico ya está en uso.';

        }

        return $result;
    }

    public static function disabledItem($id)
    {
        $item   = self::find($id);
        $result = (object)[
            'type'  => false,
            'find'  => ''
        ];
            
        $item->is_active = self::DISABLED; 
        
        if($item->update()) {

            $result->type = true;

        }        
        
        return $result;
    }   

    public static function validateEmail($email, $selected_id)
    {
        $result = false;
        $query  = self::query()
            ->where('is_active', self::ENABLED)
            ->where('email', $email);
        
        if ($selected_id) {

            $query->where('id', '!=',$selected_id);$query->where('id', '!=', $selected_id);

        }

        $validation = $query->exists();
      
        if ($validation) {
            
            $result = true;
            
        }

        return $result;
    }
}
