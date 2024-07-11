<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public static function getItemProductsByDateRange($date_start, $date_end)
    {
        $date_start = date('Y-m-d H:i:s', strtotime($date_start));
        $date_end   = date('Y-m-d H:i:s', strtotime($date_end));

        $query  = self::query()
            ->select('detail')
            ->whereBetween('created_at', [$date_start, $date_end])
            ->where('is_active', self::ENABLED)
            ->get();
        
        
        $sale_details   = collect([]);
        $sale_products  = collect([]);

        foreach ($query as $key => $detail) {

            $details             = json_decode($detail->detail); 
            $sale_details[$key]  = $details;

        }
        
        foreach ($sale_details as $sal => $sale) {
            
            foreach ($sale as $cod => $product) {
                
                if (isset($sale_products[$product->id])) {

                    $sale_products[$product->id]->quantity += $product->quantity;
                    $sale_products[$product->id]->total    += $product->total;

                } else {

                    $sale_products[$product->id] = (object) [
                        'id'        => $product->id,
                        'code'      => $product->code,
                        'name'      => $product->name,
                        'price'     => $product->price,
                        'quantity'  => $product->quantity,
                        'total'     => $product->total,
                    ];

                }

            }

        }
        
        return $sale_products->sortByDesc('quantity');
    }

    public static function getItemProducts($take)
    {
        $query  = self::query()
            ->select('detail')
            ->where('is_active', self::ENABLED)
            ->get();

        $sale_details   = collect([]);
        $sale_products  = collect([]);

        foreach ($query as $key => $detail) {

            $details             = json_decode($detail->detail); 
            $sale_details[$key]  = $details;

        }
        
        foreach ($sale_details as $sal => $sale) {
            
            foreach ($sale as $cod => $product) {
                
                if (isset($sale_products[$product->id])) {

                    $sale_products[$product->id]->quantity += $product->quantity;
                    $sale_products[$product->id]->total    += $product->total;

                } else {

                    $sale_products[$product->id] = (object) [
                        'id'        => $product->id,
                        'code'      => $product->code,
                        'name'      => $product->name,
                        'price'     => $product->price,
                        'quantity'  => $product->quantity,
                        'total'     => $product->total,
                    ];

                }

            }

        }
        
        if ($take) {

            $top_products = $sale_products
                ->sortByDesc('quantity')
                ->take($take);

        } else {

            $top_products = $sale_products
                ->sortByDesc('quantity');

        }

        return $top_products;
    }

    public static function saveItem($data)
    {
        $result = (object)[
            'type'      => false,
            'find'      => '',
            'sale_id'   => null,
        ];
        
        $createItem = self::createItem($data, $result);
        
        return $createItem;        
    }

    public static function createItem($data, $result)
    { 
        $item                   = new self();
        $item->ticket           = $data->ticket;
        $item->amount_total     = $data->amount_total;
        $item->amount_payment   = $data->amount_payment;
        $item->amount_change    = $data->amount_change;
        $item->detail           = $data->detail;
        $item->is_active        = self::ENABLED;

        if($item->save()) {

            $result->type       = true;
            $result->sale_id    = $item->id;

        }
        
        return $result;
    }

    public static function getProducts()
    {
        return Product::getItems();    
    }

    public static function getProductById($id)
    {
        return Product::getItemById($id);    
    }

    public static function getProductByCode($product_code)
    {
        return Product::getItemByCode($product_code);    
    }

}
