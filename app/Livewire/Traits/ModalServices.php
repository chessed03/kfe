<?php

namespace App\Livewire\Traits;

trait ModalServices
{

      
    // ********************************************************************* //
    // **! Eventos que despachan apaertura y cierre de modales, por cada !** //
    // **! evento se accionan funciones definidas como predeterminadas,  !** //
    // **! las cuales retorna al componente donde se haga uso de este    !** //
    // **! trait.                                                        !** //
    // ********************************************************************* //
      
    public $modal_title, $modal_target, $selected_id, $update_mode;

    /** 
     * @param string $modal_title
     * @param string $modal_target
     * @param int $selected_id
     * @param boolean $update_mode
     * @return void
     */
    public function msOpenModal($modal_target, $modal_title, $selected_id)
    {
        $this->resetFieldsAndHydrate();
        $this->modal_title  = $modal_title;
        $this->modal_target = $modal_target;
        $this->update_mode  = $selected_id ? true : false;

        if ($this->update_mode) {
            $this->selected_id  = $selected_id;
            $this->getItemById();
        }

        $this->dsOpenModal($this->modal_target);
    }

    public function msCloseModal()
    {
        $this->dsCloseModal($this->modal_target);
        $this->resetFieldsAndHydrate();
    }

    abstract protected function resetFieldsAndHydrate();
    abstract protected function getItemById();
    abstract protected function dsOpenModal($modal_target);
    abstract protected function dsCloseModal($modal_target);
}
