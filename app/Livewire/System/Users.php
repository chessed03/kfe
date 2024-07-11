<?php

namespace App\Livewire\System;

use App\Livewire\Traits\DispatchServices;
use App\Livewire\Traits\ModalServices;
use Livewire\WithPagination;
use App\Models\System\User;
use Livewire\Component;

class Users extends Component
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
    public $name, $email, $type_id, $password, $is_active;
    //**! Variables to needs into component         ***//
    public $password_confirmation, $password_update, $list_types;

    public function mount()
    {

        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Nombre',    'class' => '',              'width' => '20%'],
            (object)['name' => 'Correo',    'class' => '',              'width' => '35%'],
            (object)['name' => 'Tipo',      'class' => 'text-center',   'width' => '15%'],
            (object)['name' => 'Estado',    'class' => 'text-center',   'width' => '15%'],
            (object)['name' => 'Acciones',  'class' => 'text-right',    'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Revise sus datos antes de crear un nuevo usuario',
            'Los campos marcados con (*) son obligatorios',
            'Cada correo debe ser único',
            'La contraseña debe tener al menor 8 caracteres',
        ];

        $this->list_types = _getTypes_();
    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id              = null;
        $this->name                     = null;
        $this->email                    = null;
        $this->password                 = null;
        $this->password_confirmation    = null;
        $this->type_id                  = null;
        $this->is_active                = null;
        $this->password_update          = false;
        $this->update_mode              = false;
        
        $this->dsSelectSelected('type_id', null);
        $this->dsSelectSelected('is_active', null);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function validateData()
    {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email',
            'type_id'   => 'required',
        ];

        if ($this->update_mode && $this->password_update) {

            $rules['password']              = 'required|confirmed|min:8';
            $rules['password_confirmation'] = 'required';

        }

        if (!$this->update_mode) {

            $rules['password']              = 'required|confirmed|min:8';
            $rules['password_confirmation'] = 'required';

        }

        if ($this->update_mode) {

            $rules['is_active'] = 'required';
            
        }

        $messages = [
            'required'  => 'El campo es requerido.',
            'email'     => 'El correo debe ser una dirección válida.',
            'confirmed' => 'La confirmación de la contraseña no coincide.',
            'min'       => 'La contraseña debe tener al menos 8 caracteres.',
        ];

        $this->validate($rules, $messages);
    }

    public function getItemById()
    {
        $item                           = User::getItemById($this->selected_id); 
        $this->name                     = $item->name;
        $this->email                    = $item->email;
        $this->password                 = null;
        $this->password_confirmation    = null;
        $this->type_id                  = $item->type_id;
        $this->is_active                = $item->is_active;
        
        $this->dsSelectSelected('type_id', $item->type_id);
        $this->dsSelectSelected('is_active', $item->is_active);
    }

    public function saveItem()
    {      
        $this->validateData();
        
        $data = (object)[
            'selected_id'       => $this->selected_id,
            'name'              => $this->name,
            'email'             => $this->email,
            'type_id'           => $this->type_id,
            'password'          => $this->password,
            'password_update'   => $this->password_update,
            'is_active'         => $this->is_active,
            'update_mode'       => $this->update_mode
        ];
      
        $result = User::saveItem($data);
        
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

    public function changePassword()
    {
        $this->password_update = !$this->password_update;
    }
    
    public function deleteItem($target, $item_id, $item_name)
    {
        $content = (Object)[
            'id'        => $item_id,
            'name'      => $item_name,
            'inModule'  => 'el usuario'
        ];
        
        $this->dsAlertDeleteItem($target, $content);
    }

    public function disabledItem($id)
    {
        $result = User::disabledItem($id);
        
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
        $listModule         = User::getShowItems($key_word, $paginate_number, $order_by);
        
        $this->setPage(1);

        return view('livewire.system.users', [
            'listModule' => $listModule,
        ]);
    }
}
