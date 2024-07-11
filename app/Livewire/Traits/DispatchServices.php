<?php

namespace App\Livewire\Traits;

trait DispatchServices
{
    
    // ********************************************************************* //
    // **! Eventos que despachan a funciones que escuchan en el archivo  !** //
    // **! global.js, las funciones ejecutan el dispacht() en la funcion !** //
    // **! eventDispatch(), que posee el evento ->dispatch().            !** //
    // ********************************************************************* //
      
    /** 
    * @param string $type
    * @param string $title
    * @param string $text
    * @return void
    */
    public function dsToasMessage($type, $title, $text)
    {
        $content = (object)[
            'type'  => $type,
            'title' => $title,
            'text'  => $text  
        ];

        $this->eventDispatch('toastMessage', null, $content);
    }

    public function dsToasMessageSuccess($text)
    {
        $content = (object)[
            'type'  => "success",
            'title' => "Exito!",
            'text'  => "Registro {$text} correctamente.",
        ];

        $this->eventDispatch('toastMessage', null, $content);
    }

    public function dsToasMessageWarning($text)
    {
        $content = (object)[
            'type'  => "warning",
            'title' => "Advertencia!",
            'text'  => "{$text}",
        ];

        $this->eventDispatch('toastMessage', null, $content);
    }

    public function dsToasMessageError($text)
    {
        $content = (object)[
            'type'  => "error",
            'title' => "Error!",
            'text'  => "{$text}",
        ];

        $this->eventDispatch('toastMessage', null, $content);
    }

    /** 
    * @param string $target
    * @param string $content
    * @return void
    */
    public function dsAlertDeleteItem($target, $content)
    {
        $this->eventDispatch('alertDeleteItem', $target, $content);
    }

    /** 
    * @param string $modalTarget
    * @return void
    */
    public function dsOpenModal($modalTarget)
    {
        $this->eventDispatch('showModal', $modalTarget, null);
    }

    public function dsCloseModal($modalTarget)
    {
        $this->eventDispatch('hideModal', $modalTarget, null);
    }

    /** 
    * @param string $target
    * @param string $content
    * @return void
    */

    public function dsInitSelect()
    {
        $this->eventDispatch('initSelectpicker', null, null);
    }

    public function dsSelectOptions($target, $content)
    {
        $this->eventDispatch('selectOptions', $target, $content);
    }

    public function dsSelectSelected($target, $content)
    {
        $content = $this->guardContentArray($content);
        
        $this->eventDispatch('selectSelected', $target, $content);
    }

    public function dsSelectOptionsDynamic($target, $content)
    {
        $content = $this->guardContentArray($content);
        
        $this->eventDispatch('selectOptionsDynamic', $target, $content);
    }

    public function dsSelectSelectedDynamic($target, $content)
    {
        $content = $this->guardContentArray($content);

        $this->eventDispatch('selectSelectedDynamic', $target, $content);
    }

    /** 
    * @param string $target
    * @param array $content
    * @return void
    */

    public function dsShowTicket($target)
    {
        $content = [];
        $this->eventDispatch('showTicket', $target, $content);
    }
   
    /** 
    * @param string $target
    * @param array $content
    * @return void
    */

    public function dsGraphBarChart($target, $content)
    {
        $this->eventDispatch('graphBarChart', $target, $content);
    }

    public function guardContentArray($content)
    {
        if (is_null($content)) {
            
            $content = [];

        } 

        $content = collect($content)->toArray();
           
        return $content;
    }

    public function eventDispatch($function, $target, $content)
    {
        $this->dispatch('fnExecListener',
            function    : $function, 
            target      : $target,
            content     : $content
        );
    }

}