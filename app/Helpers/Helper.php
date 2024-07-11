<?php

use Magarrent\LaravelCurrencyFormatter\Facades\Currency;

//** Generate custom arrays **//

function _getMenuSidebar_(){

    $result = (object)[
        (object)[
            'route'         => 'user.index',
            'icon'          => 'la la-user',
            'name'          => 'Usuarios',
            'menu'          => '#',
            'submenu'       => false,
            'itemsSubmenu'  => (object)[],
            'access'        => [1],    
        ],
        (object)[
            'route'         => '#',
            'icon'          => 'la la-institution',
            'name'          => 'Administración',
            'menu'          => '#',
            'submenu'       => true,
            'itemsSubmenu'  => (object)[
                (object)[
                    'route' => 'category.index',
                    'name'  => 'Categorias',
                    'menu'  => 'categories',
                ],
                (object)[
                    'route' => 'product.index',
                    'name'  => 'Productos',
                    'menu'  => 'products',
                ],
            ],
            'access'        => [1,3], 
        ],
        (object)[
            'route'         => 'sale.index',
            'icon'          => 'la la-coffee',
            'name'          => 'Ventas',
            'menu'          => '#',
            'submenu'       => false,
            'itemsSubmenu'  => (object)[],
            'access'        => [1,4],
        ],
        (object)[
            'route'         => '#',
            'icon'          => 'la la-bar-chart',
            'name'          => 'Reportes',
            'menu'          => '#',
            'submenu'       => true,
            'itemsSubmenu'  => (object)[
                (object)[
                    'route' => 'report.index',
                    'name'  => 'Reportes',
                    'menu'  => 'reports',
                ],
            ],
            'access'        => [1,2],
        ],
    ];
    
    return collect($result);

}

function _getTypes_()
{
    $result = (object)[
        (object)[
            'id'    => 1,
            'name'  => 'Root'
        ],
        (object)[
            'id'    => 2,
            'name'  => 'Gerente'
        ],
        (object)[
            'id'    => 3,
            'name'  => 'Administrador'
        ],
        (object)[
            'id'    => 4,
            'name'  => 'Caja'
        ],
    ];
    
    return collect($result);
}

function _currencyFormat_($amount) 
{
    return Currency::currency("MXN")->format($amount);
}

//** Generate names of custom arrays **//

function _getItemNames_($items, $itemsCollection)
{
    $result = '';

    $count = count($items);

    foreach ($items as $key => $itemId) {

        $query = $itemsCollection->where('id', $itemId)->first();

        if ($query) {

            $result .= $query->name;

            if ($key < $count - 1) {

                $result .= " - ";
                
            }

        }
    
    }

    return $result;
}

function _getTypeNames_($typeSubjects)
{

    $arrayValidate = is_array($typeSubjects);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = _getTypes_();
        $result             = _getItemNames_($typeSubjects, $itemsCollection);
    }

    return $result;

}
