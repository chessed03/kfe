<?php

namespace App\Livewire\System;

use App\Livewire\Traits\DispatchServices;
use App\Livewire\Traits\ModalServices;
use App\Models\System\Category;
use Livewire\WithPagination;
use Livewire\Component;

class Categories extends Component
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
    public $name, $description, $is_active;
   
    public function mount()
    {
        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Nombre',        'class' => '',              'width' => '20%'],
            (object)['name' => 'Descripción',   'class' => '',              'width' => '50%'],
            (object)['name' => 'Estado',        'class' => 'text-center',   'width' => '15%'],
            (object)['name' => 'Acciones',      'class' => 'text-right',    'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Revise sus datos antes de crear una nueva categoría',
            'Los campos marcados con (*) son obligatorios',
        ];
    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id  = null;
        $this->name         = null;
        $this->description  = null;
        $this->is_active    = null;
        $this->update_mode  = false;
        
        $this->dsSelectSelected('is_active', null);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function validateData()
    {
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
        ];

        if ($this->update_mode) {

            $rules['is_active'] = 'required';

        }

        $messages = [
            'required' => 'El campo es requerido.',
        ];

        $this->validate($rules, $messages);
    }

    public function getItemById()
    {
        $item               = Category::getItemById($this->selected_id);
        
        $this->name         = $item->name;
        $this->description  = $item->description;
        $this->is_active    = $item->is_active;
        
        $this->dsSelectSelected('is_active', $item->is_active);
    }

    public function saveItem()
    {         
        $this->validateData();
        
        $data = (object)[
            'selected_id'   => $this->selected_id,
            'name'          => $this->name,
            'description'   => $this->description,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
      
        $result = Category::saveItem($data);
        
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

    public function deleteItem($target, $item_id, $item_name)
    {  
        $content = (Object)[
            'id'        => $item_id,
            'name'      => $item_name,
            'inModule'  => 'la categoría'
        ];
        
        $this->dsAlertDeleteItem($target, $content);
    }

    public function disabledItem($id)
    {
        $result = Category::disabledItem($id);
        
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
        $listModule         = Category::getShowItems($key_word, $paginate_number, $order_by);

        $this->setPage(1);

        return view('livewire.system.categories', [
            'listModule' => $listModule,
        ]);
    }
}
