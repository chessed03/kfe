<?php

namespace App\Livewire\System;

use App\Livewire\Traits\DispatchServices;
use App\Livewire\Traits\ModalServices;
use App\Models\System\Product;
use Livewire\WithPagination;
use Livewire\Component;

class Products extends Component
{
    use DispatchServices;
    use WithPagination;
    use ModalServices;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;
    //*** Default variables to needs into component ***//
    public $action_loader, $headers_table, $modal_title,  $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;
    //**! Variables to needs into model             ***//
    public $category_id, $code, $name, $description, $is_active;
    //**! Variables to needs into component         ***//
    public $list_categories, $price_update, $price;

    public function mount()
    {
        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Código',        'class' => '',              'width' => '10%'],
            (object)['name' => 'Nombre',        'class' => '',              'width' => '25%'],
            (object)['name' => 'Categoría',     'class' => '',              'width' => '25%'],
            (object)['name' => 'Precio',        'class' => 'ext-center',    'width' => '10%'],
            (object)['name' => 'Estado',        'class' => 'text-center',   'width' => '15%'],
            (object)['name' => 'Acciones',      'class' => 'text-right',    'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Revise sus datos antes de crear un nuevo producto',
            'El código del producto debe contener 8 digitos de entre 0 y 9',
            'Registrar el precio del producto con IVA incluido',
            'Los campos marcados con (*) son obligatorios',
        ];

        $this->list_categories  = Product::getCategories();
    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id  = null;
        $this->category_id  = null;
        $this->code         = null;
        $this->name         = null;
        $this->description  = null;
        $this->price        = null;
        $this->is_active    = null;
        $this->price_update = false;
        $this->update_mode  = false;
        
        $this->dsSelectSelected('category_id', null);
        $this->dsSelectSelected('is_active', null);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function validateData()
    {
        $rules = [
            'category_id'   => 'required',
             'code'         => 'required|numeric|digits:8',
            'name'          => 'required',
            'description'   => 'required',
            'price'         => 'required',
        ];

        if ($this->update_mode) {

            $rules['is_active'] = 'required';

        }

        $messages = [
            'required'  => 'El campo es requerido.',
            'numeric'   => 'El código deber ser numerico',
            'digits'    => 'El código debe tener exactamente 8 dígitos',
        ];

        $this->validate($rules, $messages);
    }

    public function getItemById()
    {
        $item               = Product::getItemById($this->selected_id);
        
        $this->category_id  = $item->category_id;
        $this->code         = $item->code;
        $this->name         = $item->name;
        $this->description  = $item->description;
        $this->price        = $item->price;
        $this->is_active    = $item->is_active;
        
        $this->dsSelectSelected('category_id', $item->is_active);
        $this->dsSelectSelected('is_active', $item->is_active);
    }

    public function saveItem()
    {         
        $this->validateData();
        
        $data = (object)[
            'selected_id'   => $this->selected_id,
            'category_id'   => $this->category_id,
            'code'          => $this->code,
            'name'          => $this->name,
            'description'   => $this->description,
            'price'         => $this->price,
            'is_active'     => $this->is_active,
            'price_update'  => $this->price_update,
            'update_mode'   => $this->update_mode
        ];
        
        $result = Product::saveItem($data);
        
        if ($result->type) {

            $mode_saved = $this->update_mode ? 'editado' : 'creado';

            $this->dsToasMessageSuccess($mode_saved);

        } else {

            if ($result->find != '') {

                $this->dsToasMessageWarning($result->find);

            } else {

                $this->dsToasMessageError('Ha ocurrido un error.');

            }

        }

        $this->msCloseModal(); 
    }

    public function changePrice()
    {
        $this->price_update = !$this->price_update;
    }

    public function deleteItem($target, $item_id, $item_name)
    {  
        $content = (Object)[
            'id'        => $item_id,
            'name'      => $item_name,
            'inModule'  => 'el producto'
        ];
        
        $this->dsAlertDeleteItem($target, $content);
    }

    public function disabledItem($id)
    {
        $result = Product::disabledItem($id);
        
        if ($result->type) {

            $this->dsToasMessageSuccess('eliminado');

        } else {

            if ($result->find != '') {

                $this->dsToasMessageWarning($result->find);

            } else {

                $this->dsToasMessageError('Ha ocurrido un error.');
            }

        }
    }

    public function render()
    {
        $key_word           = '%' . $this->key_word . '%';
        $paginate_number    = $this->paginate_number;
        $order_by           = intval($this->order_by);
        $listModule         = Product::getShowItems($key_word, $paginate_number, $order_by);

        $this->setPage(1);

        return view('livewire.system.products', [
            'listModule' => $listModule,
        ]);
    }
}
